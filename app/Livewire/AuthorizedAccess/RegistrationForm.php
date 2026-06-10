<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessUser;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class RegistrationForm extends Component
{
    public string $name = '';
    public string $surname = '';
    public string $company = '';
    public string $email = '';
    public string $phone = '';
    public string $login = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $sent = false;

    protected function rules(): array
    {
        return [
            'name' => 'required|string|min:2|max:120',
            'surname' => 'required|string|min:2|max:120',
            'company' => 'required|string|max:160',
            'email' => 'required|email:rfc|max:255|unique:authorized_access_users,email',
            'phone' => 'required|string|max:32',
            'login' => 'required|string|min:4|max:120|unique:authorized_access_users,login',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    public function submit(): void
    {
        $this->sent = false;

        $throttleKey = 'authorized-access-register:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $this->addError('email', __('Příliš mnoho pokusů. Zkuste to prosím za chvíli.'));
            return;
        }
        RateLimiter::hit($throttleKey, 60);

        $validated = $this->validate();

        $user = AuthorizedAccessUser::create([
            'name' => $validated['name'],
            'surname' => $validated['surname'],
            'company' => $validated['company'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'login' => $validated['login'],
            'password' => $validated['password'],
            'lang_locale' => app()->currentLocale(),
        ]);

        event(new Registered($user));

        $this->reset([
            'name',
            'surname',
            'company',
            'email',
            'phone',
            'login',
            'password',
            'password_confirmation',
        ]);

        $this->sent = true;
    }

    public function render()
    {
        return view('livewire.authorized-access.registration-form');
    }
}