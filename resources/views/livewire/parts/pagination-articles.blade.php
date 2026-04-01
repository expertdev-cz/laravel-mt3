@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex w-full items-center justify-center">
        <div class="flex w-full items-center justify-between gap-3 sm:hidden">
            <button
                @if ($paginator->onFirstPage()) disabled @endif
                type="button"
                wire:click="previousPage('{{ $paginator->getPageName() }}')"
                class="inline-flex h-9 items-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Předchozí
            </button>

            <button
                @if (! $paginator->hasMorePages()) disabled @endif
                type="button"
                wire:click="nextPage('{{ $paginator->getPageName() }}')"
                class="inline-flex h-9 items-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
            >
                Další
            </button>
        </div>

        <div class="hidden items-center justify-center sm:flex">
            <ul class="inline-flex items-center gap-2">
                <li>
                    <button
                        @if ($paginator->onFirstPage()) disabled @endif
                        type="button"
                        wire:click="previousPage('{{ $paginator->getPageName() }}')"
                        class="inline-flex h-9 items-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Předchozí
                    </button>
                </li>

                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="inline-flex h-9 min-w-9 items-center justify-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-400">
                                {{ $element }}
                            </span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span aria-current="page" class="inline-flex h-9 min-w-9 items-center justify-center rounded-md bg-slate-900 px-3 text-sm font-semibold text-white">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <button
                                        type="button"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')"
                                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                                    >
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                <li>
                    <button
                        @if (! $paginator->hasMorePages()) disabled @endif
                        type="button"
                        wire:click="nextPage('{{ $paginator->getPageName() }}')"
                        class="inline-flex h-9 items-center rounded-md border border-slate-200 bg-white px-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50 disabled:cursor-not-allowed disabled:opacity-50"
                    >
                        Další
                    </button>
                </li>
            </ul>
        </div>
    </nav>
@endif
