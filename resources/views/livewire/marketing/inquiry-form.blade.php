<div>
    @if($sent)
        <p class="ap-registration-label text-dark-grey mt-4 scroll-in">{{ __('Zpráva byla odeslána. Brzy se Vám ozveme.') }}</p>
    @else
        <form wire:submit.prevent="submit" class="ap-registration-form" autocomplete="off" novalidate>

            <p class="ap-registration-label" style="margin-bottom: 0.5rem;">{{ __('Údaje o Vás') }}</p>

            <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.1rem;">
                <label for="ap-jmeno" class="ap-registration-label" style="min-width: 110px;">{{ __('Jméno') }}: *</label>
                <input wire:model="name" type="text" id="ap-jmeno" name="jmeno" class="ap-registration-input" autocomplete="given-name">
                @error('name')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 0.3rem;">
                <label for="ap-prijmeni" class="ap-registration-label" style="min-width: 110px;">{{ __('Příjmení') }}: *</label>
                <input wire:model="surname" type="text" id="ap-prijmeni" name="prijmeni" class="ap-registration-input" autocomplete="family-name">
                @error('surname')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
                <label for="ap-firma" class="ap-registration-label" style="min-width: 110px;">{{ __('Firma') }}:</label>
                <input wire:model="company" type="text" id="ap-firma" name="firma" class="ap-registration-input" autocomplete="organization">
                @error('company')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
                <label for="ap-email" class="ap-registration-label" style="min-width: 110px;">{{ __('e-mail') }}: *</label>
                <input wire:model="email" type="email" id="ap-email" name="email" class="ap-registration-input" autocomplete="email">
                @error('email')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="ap-registration-field" style="flex-direction: row; align-items: center; gap: 1.5rem;">
                <label for="ap-tel" class="ap-registration-label" style="min-width: 110px;">{{ __('tel.') }}: *</label>
                <input wire:model="phone" type="tel" id="ap-tel" name="tel" class="ap-registration-input ap-registration-input-short" placeholder="+420" autocomplete="tel">
                @error('phone')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <p class="ap-registration-label" style="margin-bottom: 0.5rem; margin-top: 2rem;">{{ __('Text zprávy') }}</p>

            <div class="ap-registration-field" style="width: 100%;">
                <textarea wire:model="content" id="ap-zprava" name="zprava" class="ap-registration-input" style="resize: vertical; width: 100% !important; height: 28rem; border-radius: 35px;"></textarea>
                @error('content')<span class="ap-field-error">{{ $message }}</span>@enderror
            </div>

            <div class="ap-registration-btn-row d-flex justify-content-between align-items-center mt-3" style="width: 100%;">
                <p class="text-page-text text-dark-grey fw-light mb-0">* {{ __('povinný údaj') }}</p>
                <button class="form-submit-button me-4" type="submit" wire:loading.attr="disabled" wire:target="submit">
                    <span wire:loading.remove wire:target="submit">{{ __('Odeslat') }}</span>
                    <span wire:loading wire:target="submit">{{ __('Odesílám…') }}</span>
                </button>
            </div>

        </form>
    @endif
</div>