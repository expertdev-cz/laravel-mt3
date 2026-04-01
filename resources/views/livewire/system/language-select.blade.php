<div class="flex items-center gap-2">
    @foreach ($langs as $item)
        <a
            wire:click.prevent="changeLang('{{ $item->locale }}','{{ request()->getRequestUri() }}')"
            href="#"
            class="inline-flex items-center gap-2 rounded-md border px-2 py-1 text-xs font-medium uppercase tracking-wide transition {{ app()->getLocale() === $item->locale ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-300 bg-white text-slate-700 hover:bg-slate-100' }}"
            title="{{ $item->name ?? strtoupper($item->locale) }}"
        >
            @if (!empty($item->icon))
                <img src="/storage/{{ $item->icon }}" alt="{{ $item->locale }}" class="h-4 w-4 rounded-sm object-cover" />
            @endif
            <span>{{ strtoupper($item->locale) }}</span>
        </a>
    @endforeach
</div>