<?php

namespace App\Livewire\Footer;

use App\Models\AuthorizedAccess\AuthorizedAccessUser;
use Livewire\Component;

class ApEmailCheck extends Component
{
    public string $email = '';
    public string $loginUrl = '';
    public string $registerUrl = '';

    public function mount(string $loginUrl, string $registerUrl): void
    {
        $this->loginUrl = $loginUrl;
        $this->registerUrl = $registerUrl;
    }

    public function submit(): mixed
    {
        $this->validate([
            'email' => 'required|email:rfc|max:255',
        ], [
            'email.required' => __('Zadejte prosím e-mail.'),
            'email.email'    => __('Zadejte platný e-mail.'),
        ]);

        $exists = AuthorizedAccessUser::where('email', $this->email)->exists();

        if (!$exists) {
            $this->addError('email', __('Tento e-mail není registrován. Zaregistrujte se prosím.'));
            return null;
        }

        return $this->redirect($this->loginUrl . '?email=' . urlencode($this->email));
    }

    public function render()
    {
        return view('livewire.footer.ap-email-check');
    }
}
