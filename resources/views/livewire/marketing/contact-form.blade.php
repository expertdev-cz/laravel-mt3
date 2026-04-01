<section class="py-6">
  <form wire:submit.prevent="submit" class="space-y-5" novalidate>

    <div class="hidden" aria-hidden="true">
      <input wire:model.defer="company" type="text" name="company" tabindex="-1" autocomplete="off" />
      <select wire:model.defer="topic_confirm" name="topic_confirm" tabindex="-1">
        <option value="">--leave-empty--</option>
        <option value="x">x</option>
      </select>
    </div>

    <div class="grid gap-5 md:grid-cols-2">
      <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Jméno</label>
        <input wire:model.defer="name" name="name" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
        @error('name')
          <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
      </div>
      <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">E-mail</label>
        <input wire:model.defer="email" name="email" type="email" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
        @error('email')
          <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div class="grid gap-5 md:grid-cols-3">
      <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Prefix</label>
        <select wire:model.defer="prefix" name="prefix" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none">
          <option value="+420">+420</option>
          <option value="+421">+421</option>
        </select>
      </div>
      <div class="md:col-span-2">
        <label class="mb-1 block text-sm font-medium text-slate-700">Telefon</label>
        <input wire:model.defer="phone" name="phone" type="tel" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
        @error('phone')
          <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
        @enderror
      </div>
    </div>

    <div>
      <label class="mb-1 block text-sm font-medium text-slate-700">Zpráva</label>
      <textarea wire:model.defer="content" name="content" rows="5" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none"></textarea>
      @error('content')
        <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
      @enderror
    </div>

    <div class="flex items-center gap-3">
      <button type="submit" class="inline-flex rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60" wire:loading.attr="disabled" wire:target="submit">
        <span wire:loading.remove wire:target="submit">Odeslat formulář</span>
        <span wire:loading wire:target="submit">Odesílám...</span>
      </button>
      @if($sent)
        <p class="text-sm font-medium text-emerald-700">Odesláno.</p>
      @endif
      @error('general')
        <p class="text-sm font-medium text-red-700">{{ $message }}</p>
      @enderror
    </div>
  </form>
</section>
