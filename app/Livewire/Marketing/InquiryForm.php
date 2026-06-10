<?php

namespace App\Livewire\Marketing;

use App\Mail\ContactFormMail;
use App\Models\Marketing\ContactFormRequest;
use App\Models\System\Settings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;
use Throwable;

class InquiryForm extends Component
{
    public string $name = '';
    public string $surname = '';
    public string $company = '';
    public string $email = '';
    public string $phone = '';
    public string $content = '';
    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:120',
            'surname' => 'required|string|min:2|max:120',
            'company' => 'nullable|string|max:160',
            'email' => 'required|email:rfc|max:255',
            'phone' => ['required', 'string', 'max:32', 'regex:/^\+\d[\d\s\-]{6,}/'],
            'content' => 'required|string|min:12|max:5000',
        ];
    }

    protected function messages(): array
    {
        return [
            'phone.regex' => __('Zadejte telefon ve formátu +420 000 000 000.'),
        ];
    }

    public function submit(): void
    {
        $this->sent = false;

        $key = 'inquiry:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 20)) {
            $this->addError('content', __('Příliš mnoho požadavků, zkuste to prosím za chvíli.'));
            return;
        }
        RateLimiter::hit($key, 60);

        $validated = $this->validate();

        $message = trim(
            'Firma: ' . ($validated['company'] ?: '-') . PHP_EOL .
            'Telefon: ' . ($validated['phone'] ?: '-') . PHP_EOL . PHP_EOL .
            $validated['content']
        );

        $setting = Settings::find(1);
        $to = $setting->content['mailContactForm'] ?? null;

        if (!empty($to)) {
            try {
                Mail::to($to)->send(new ContactFormMail(
                    trim($validated['name'] . ' ' . $validated['surname']),
                    $validated['email'],
                    $validated['phone'] ?: '-',
                    $message,
                ));
            } catch (Throwable $e) {
                report($e);
                $this->addError('content', __('Odeslání se nepodařilo. Zkuste to prosím za chvíli.'));
                return;
            }
        }

        ContactFormRequest::create([
            'name' => trim($validated['name'] . ' ' . $validated['surname']),
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'content' => $message,
            'lang_locale' => app()->getLocale(),
            'page_url' => url()->current(),
        ]);

        $this->reset(['name', 'surname', 'company', 'email', 'phone', 'content']);
        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.marketing.inquiry-form');
    }
}