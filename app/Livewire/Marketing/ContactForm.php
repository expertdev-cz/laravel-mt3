<?php

namespace App\Livewire\Marketing;

use App\Mail\ContactFormMail;
use App\Models\Marketing\ContactFormRequest as ContactFormEntry;
use App\Models\System\Settings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Throwable;

class ContactForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $prefix = '+420';
    public string $phone = '';
    public string $content = '';

    // Honeypot fields. Must stay empty/default.
    public string $company = '';
    public string $topic_confirm = '';

    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|max:128|min:5',
            'email' => 'required|email:rfc|max:255',
            'prefix' => 'required|in:+420,+421',
            'phone' => ['required', 'regex:/^[0-9]{9,16}$/'],
            'content' => 'required|min:32',
            'company' => 'nullable|size:0',
            'topic_confirm' => 'nullable|in:',
        ];
    }

    public function submit(): void
    {
        $this->sent = false;

        $key = 'contact:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 30)) {
            $this->addError('general', 'Příliš mnoho požadavků, zkuste to prosím za chvíli.');
            return;
        }
        RateLimiter::hit($key, 60);

        $validated = $this->validate();

        $linksCount = preg_match_all('~https?://~i', $validated['content']);
        if ($linksCount > 2) {
            $this->addError('content', 'Zpráva obsahuje příliš mnoho odkazů.');
            return;
        }

        $setting = Settings::find(1);
        $to = $setting->content['mailContactForm'] ?? null;
        if (empty($to)) {
            $this->addError('general', 'Odeslání se nepodařilo. Kontaktujte prosím podporu.');
            return;
        }

        try {
                Mail::to($to)->send(new ContactFormMail(
                    $validated['name'],
                    $validated['email'],
                    $validated['prefix'] . $validated['phone'],
                    $validated['content']
                ));
        } catch (Throwable $e) {
            report($e);
            $this->addError('general', 'Odeslání se nepodařilo. Zkuste to prosím za chvíli.');
            return;
        }

        ContactFormEntry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['prefix'] . $validated['phone'],
            'content' => $validated['content'],
            'lang_locale' => app()->getLocale(),
            'page_url' => url()->current(),
        ]);

        $this->reset(['name', 'email', 'phone', 'content', 'company', 'topic_confirm']);
        $this->prefix = '+420';
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.marketing.contact-form');
    }
}
