<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between mx-auto text-end">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between flex justify-center">
                @if ($paginator->hasMorePages())
                    <a href="#" dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click="nextPage('{{ $paginator->getPageName() }}')"  wire:loading.attr="disabled" class="theme-btn5 font-outfit font-16 weight-700">
                        Další
                    </a>
                @endif
            </div>
        </nav>
    @endif
</div>
