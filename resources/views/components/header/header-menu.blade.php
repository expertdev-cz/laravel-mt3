<header class="sticky top-0 z-50 border-b border-slate-200 bg-white/95 backdrop-blur">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
    <a href="{{ $slugLocale ?: '/' }}" class="text-lg font-bold text-slate-900">{{ $globalSettings['webName'] ?? 'CMS' }}</a>

    <nav class="hidden lg:block" aria-label="Hlavni menu">
      <ul class="flex items-center gap-2">
        @foreach(($menuItems ?? collect()) as $item)
          @include('components.header.header-menu-item', ['item' => $item])
        @endforeach
      </ul>
    </nav>

    <div class="hidden lg:block">
      <livewire:system.language-select wire:key="header-lang-desktop" />
    </div>

    <button id="mobileMenuButton" type="button" class="inline-flex items-center rounded-md border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100 lg:hidden" aria-expanded="false" aria-controls="mobileMenuPanel">
      Menu
    </button>
  </div>

  <div id="mobileMenuOverlay" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"></div>
  <aside id="mobileMenuPanel" class="fixed right-0 top-0 z-50 hidden h-full w-full max-w-xs border-l border-slate-200 bg-white p-4 shadow-xl lg:hidden">
    <div class="mb-4 flex items-center justify-between">
      <span class="text-base font-semibold text-slate-900">Navigace</span>
      <button id="mobileMenuClose" type="button" class="rounded-md border border-slate-300 px-2 py-1 text-sm text-slate-700 hover:bg-slate-100">Zavrit</button>
    </div>

    <nav aria-label="Mobilni menu">
      <ul class="space-y-1">
        @foreach(($menuItems ?? collect()) as $item)
          @include('components.header.header-menu-mobile-item', ['item' => $item])
        @endforeach
      </ul>

      <div class="mt-5 border-t border-slate-200 pt-4">
        <livewire:system.language-select wire:key="header-lang-mobile" />
      </div>
    </nav>
  </aside>
</header>

<script>
(function () {
  const button = document.getElementById('mobileMenuButton');
  const close = document.getElementById('mobileMenuClose');
  const panel = document.getElementById('mobileMenuPanel');
  const overlay = document.getElementById('mobileMenuOverlay');

  if (!button || !close || !panel || !overlay) {
    return;
  }

  const openMenu = () => {
    panel.classList.remove('hidden');
    overlay.classList.remove('hidden');
    button.setAttribute('aria-expanded', 'true');
    document.body.classList.add('overflow-hidden');
  };

  const closeMenu = () => {
    panel.classList.add('hidden');
    overlay.classList.add('hidden');
    button.setAttribute('aria-expanded', 'false');
    document.body.classList.remove('overflow-hidden');
  };

  button.addEventListener('click', openMenu);
  close.addEventListener('click', closeMenu);
  overlay.addEventListener('click', closeMenu);
  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      closeMenu();
    }
  });
})();
</script>
