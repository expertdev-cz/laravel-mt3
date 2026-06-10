<form wire:submit.prevent="submit" class="ap-login-form" novalidate autocomplete="off">

    <div class="ap-login-field">
        <label class="ap-login-label">Login nebo e-mail:</label>
        <input wire:model="login" type="text" class="ap-login-input" autocomplete="username" />
        @error('login')
            <span class="d-block mt-1 text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="ap-login-field">
        <label class="ap-login-label">Heslo:</label>
        <input wire:model="password" type="password" class="ap-login-input ap-login-input-short" autocomplete="current-password" />
        @error('password')
            <span class="d-block mt-1 text-danger small">{{ $message }}</span>
        @enderror
    </div>

    <div class="ap-login-btn-row">
        <button type="submit" class="form-submit-button" wire:loading.attr="disabled" wire:target="submit">
            <span wire:loading.remove wire:target="submit">Přihlásit se</span>
            <span wire:loading wire:target="submit">Přihlašuji...</span>
        </button>
    </div>

</form>