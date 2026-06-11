<?php

namespace App\Livewire\AuthorizedAccess;

use App\Models\AuthorizedAccess\AuthorizedAccessUser;
use App\Models\System\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class LoginForm extends Component
{
    public string $login = '';
    public string $password = '';
    public bool $remember = false;

    public function mount(): void
    {
        $this->login = request()->query('email', '');
    }

    protected function rules(): array
    {
        return [
            'login' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function submit()
    {
        $validated = $this->validate();

        $throttleKey = 'authorized-access-login:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 10)) {
            $this->addError('login', __('Příliš mnoho pokusů. Zkuste to prosím za chvíli.'));
            return null;
        }
        RateLimiter::hit($throttleKey, 60);

        $user = AuthorizedAccessUser::query()
            ->where('email', $validated['login'])
            ->orWhere('login', $validated['login'])
            ->first();

        if (!$user) {
            $this->addError('login', __('Účet nebyl nalezen.'));
            return null;
        }

        if (!$user->hasVerifiedEmail()) {
            $this->addError('login', __('Nejdříve potvrďte svůj e-mail.'));
            return null;
        }

        $credentialsKey = filter_var($validated['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'login';

        if (!Auth::guard('authorized_access')->attempt([$credentialsKey => $validated['login'], 'password' => $validated['password']], $this->remember)) {
            $this->addError('password', __('Neplatné přihlašovací údaje.'));
            return null;
        }

        $user->forceFill(['last_login_at' => now()])->save();
        session()->regenerate();

        $locale = app()->currentLocale();
        $homeSlug = Page::query()
            ->where('type', 'authorized-access-home')
            ->where('lang_locale', $locale)
            ->where('active', 1)
            ->value('slug');

        return redirect()->intended('/' . ($homeSlug ?? 'autorizovany-pristup'));
    }

    public function render()
    {
        return view('livewire.authorized-access.login-form');
    }
}