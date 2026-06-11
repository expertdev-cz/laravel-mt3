<div>
    <form wire:submit.prevent="submit" novalidate autocomplete="off">
        <div class="d-flex email-form-gap border-bottom">
            <input wire:model.defer="email"
                   type="email"
                   placeholder="{{ __('Zde zadejte e-mail.') }}"
                   class="footer-email-input"
                   autocomplete="email">
            <button type="submit" class="footer-submit-btn" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">{{ __('Přihlásit') }}</span>
                <span wire:loading wire:target="submit">{{ __('Ověřuji…') }}</span>
            </button>
        </div>
        @error('email')
            <small class="d-block mt-1" style="color: #dc3545;">{{ $message }}</small>
        @enderror
    </form>

    <small class="footer-small-text">
        {{ __('Přihlášením souhlasíte se') }}
        <a href="/zasady-ochrany-osobnich-udaju" class="footer-link-small">{{ __('zpracováním osobních údajů') }}</a>
        {{ __('firmou MT3 project a.s..') }}
    </small>

    <div class="d-flex email-form-gap mt-3">
        <span class="footer-email-input" style="font-size: 1.2rem;">{{ __('Pokud u nás nemáte vytvořen Autorizovaný přístup') }} &rarr;</span>
        <a href="{{ $registerUrl }}">
            <button type="button" class="footer-submit-btn2">{{ __('Vytvořit') }}</button>
        </a>
    </div>
</div>
