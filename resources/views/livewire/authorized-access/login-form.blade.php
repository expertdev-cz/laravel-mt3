<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    <form wire:submit.prevent="submit" class="space-y-5" novalidate>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Login nebo e-mail</label>
            <input wire:model="login" type="text" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
            @error('login')
                <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Heslo</label>
            <input wire:model="password" type="password" class="w-full rounded-lg border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none" />
            @error('password')
                <span class="mt-1 block text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <label class="flex items-center gap-3 text-sm text-slate-600">
            <input wire:model="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-slate-900 focus:ring-slate-400" />
            Pamatovat si přihlášení
        </label>

        <div class="flex items-center gap-3">
            <button type="submit" class="inline-flex rounded-lg bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-700 disabled:cursor-not-allowed disabled:opacity-60" wire:loading.attr="disabled" wire:target="submit">
                <span wire:loading.remove wire:target="submit">Přihlásit se</span>
                <span wire:loading wire:target="submit">Přihlašuji...</span>
            </button>
        </div>
    </form>
</section>