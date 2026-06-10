<form wire:submit.prevent="submit" class="ap-registration-form" novalidate autocomplete="off">

    <p class="ap-registration-label" style="margin-bottom: 0.5rem;">Údaje o Vás</p>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.1rem;">
        <label class="ap-registration-label" style="min-width: 110px;">Jméno: *</label>
        <input wire:model="name" type="text" class="ap-registration-input" autocomplete="given-name" />
        @error('name')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 0.3rem;">
        <label class="ap-registration-label" style="min-width: 110px;">Příjmení: *</label>
        <input wire:model="surname" type="text" class="ap-registration-input" autocomplete="family-name" />
        @error('surname')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">Firma: *</label>
        <input wire:model="company" type="text" class="ap-registration-input" autocomplete="organization" />
        @error('company')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">e-mail: *</label>
        <input wire:model="email" type="email" class="ap-registration-input" autocomplete="email" />
        @error('email')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
        <label class="ap-registration-label" style="min-width: 110px;">tel.: *</label>
        <input wire:model="phone" type="tel" class="ap-registration-input ap-registration-input-short" placeholder="+420" autocomplete="tel" />
        @error('phone')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <p class="ap-registration-label" style="margin-bottom: 0.5rem; margin-top: 2rem;">Přihlašovací údaje</p>

    <div class="ap-registration-field">
        <label class="ap-registration-label">Login:</label>
        <input wire:model="login" type="text" class="ap-registration-input ap-registration-input-short" placeholder="nejlépe Váš e-mail" autocomplete="username" />
        @error('login')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field">
        <label class="ap-registration-label">Heslo:</label>
        <input wire:model="password" type="password" class="ap-registration-input ap-registration-input-short" placeholder="nejméně 8 znaků" autocomplete="new-password" />
        @error('password')<span class="d-block mt-1 text-danger small">{{ $message }}</span>@enderror
    </div>

    <div class="ap-registration-field">
        <label class="ap-registration-label">Heslo potvrzení:</label>
        <input wire:model="password_confirmation" type="password" class="ap-registration-input ap-registration-input-short" placeholder="zopakujte heslo" autocomplete="new-password" />
    </div>

    <div class="ap-registration-btn-row">
        <button type="submit" class="form-submit-button mt-3" wire:loading.attr="disabled" wire:target="submit">
            <span wire:loading.remove wire:target="submit">Vytvořit</span>
            <span wire:loading wire:target="submit">Ukládám...</span>
        </button>
    </div>

    @if($sent)
        <p class="mt-3 text-page-text text-dark-grey">Účet byl založen. Zkontrolujte prosím e-mail a potvrďte registraci.</p>
    @endif

</form>