<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <form wire:submit.prevent="submit" class="space-y-5" novalidate>
        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Jméno</label>
                <input wire:model="name" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('name')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Příjmení</label>
                <input wire:model="surname" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('surname')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Firma</label>
                <input wire:model="company" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('company')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Telefon</label>
                <input wire:model="phone" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('phone')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">E-mail</label>
                <input wire:model="email" type="email" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('email')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Login</label>
                <input wire:model="login" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('login')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
        </div>

        <div class="grid gap-5 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Heslo</label>
                <input wire:model="password" type="password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
                @error('password')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Potvrzení hesla</label>
                <input wire:model="password_confirmation" type="password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Vytvořit účet</span>
                <span wire:loading wire:target="submit">Ukládám...</span>
            </button>
            @if($sent)
                <p class="text-sm font-medium text-emerald-700">Účet byl založen. Zkontrolujte prosím e-mail a potvrďte registraci.</p>
            @endif
        </div>
    </form>
</section>