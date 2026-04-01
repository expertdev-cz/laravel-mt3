<div class="w-1/2">
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between w-1/2 mx-auto text-start">
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between flex justify-center">
                @if (!$paginator->onFirstPage())
                    <a href="#" dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" wire:click="previousPage('{{ $paginator->getPageName() }}')"  wire:loading.attr="disabled" class="theme-btn5 font-outfit font-16 weight-700">
                        Předchozí
                    </a>
                @endif
            </div>
        </nav>
    @endif
</div>
