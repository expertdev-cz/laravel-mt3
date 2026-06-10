<form wire:submit.prevent="submit" class="ap-registration-form" novalidate autocomplete="off">

    <p class="ap-registration-label" style="margin-bottom: 0.5rem;">{{ __('Údaje o Vás') }}</p>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.1rem;">
        <label class="ap-registration-label" style="min-width: 110px;">{{ __('Jméno') }}: *</label>
        <input wire:model="name" type="text" class="ap-registration-input" autocomplete="given-name" />
        @error('name')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 0.3rem;">
        <label class="ap-registration-label" style="min-width: 110px;">{{ __('Příjmení') }}: *</label>
        <input wire:model="surname" type="text" class="ap-registration-input" autocomplete="family-name" />
        @error('surname')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">{{ __('Firma') }}: *</label>
        <input wire:model="company" type="text" class="ap-registration-input" autocomplete="organization" />
        @error('company')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">{{ __('e-mail') }}: *</label>
        <input wire:model="email" type="email" class="ap-registration-input" autocomplete="email" />
        @error('email')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">{{ __('tel.') }}: *</label>
        <input wire:model="phone" type="tel" class="ap-registration-input ap-registration-input-short" placeholder="+420" autocomplete="tel" />
        @error('phone')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <p class="ap-registration-label" style="margin-bottom: 0.5rem; margin-top: 2rem;">{{ __('Přihlašovací údaje') }}</p>

    <div class="ap-registration-field">
        <label class="ap-registration-label">{{ __('Login:') }}</label>
        <input wire:model="login" type="text" class="ap-registration-input ap-registration-input-short" placeholder="{{ __('nejlépe Váš e-mail') }}" autocomplete="username" />
        @error('login')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field">
        <label class="ap-registration-label">{{ __('Heslo:') }}</label>
        <input wire:model="password" type="password" class="ap-registration-input ap-registration-input-short" placeholder="{{ __('nejméně 8 znaků') }}" autocomplete="new-password" />
        @error('password')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field">
        <label class="ap-registration-label">{{ __('Heslo potvrzení:') }}</label>
        <input wire:model="password_confirmation" type="password" class="ap-registration-input ap-registration-input-short" placeholder="{{ __('zopakujte heslo') }}" autocomplete="new-password" />
    </div>

    <div class="ap-registration-btn-row">
        <button type="submit" class="form-submit-button mt-3" wire:loading.attr="disabled" wire:target="submit">
            <span wire:loading.remove wire:target="submit">{{ __('Vytvořit') }}</span>
            <span wire:loading wire:target="submit">{{ __('Ukládám…') }}</span>
        </button>
    </div>

    @if($sent)
        <p class="mt-3 text-page-text text-dark-grey">{{ __('Účet byl založen. Zkontrolujte prosím e-mail a potvrďte registraci.') }}</p>
    @endif

</form>