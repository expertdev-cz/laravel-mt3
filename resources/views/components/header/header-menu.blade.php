{{-- Header / Navbar --}}
<nav class="navbar navbar-expand-lg fixed-top navbar-custom transparent" id="mainNavbar">
    <div class="container-fluid px-4">
        {{-- Logo --}}
        <a class="navbar-brand ms4-5" href="{{ $slugLocale ?: '/' }}">
            <img src="{{ asset('assets/icons/logo_mt3-tmave.svg') }}" alt="Logo" height="50" style="filter: contrast(7);">
        </a>

        {{-- Mobile toggle --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Navigation --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            {{-- Center menu items --}}
            <ul class="navbar-nav navbar-zarovnani">
                @foreach(($menuItems ?? collect()) as $item)
                    @php
                        $menuItem = $item?->linkable;
                        if ($menuItem instanceof \App\Models\PageRouteUrls) {
                            $route = localizedRoute($menuItem->pageRoute->route_name, [data_get($menuItem, 'slug')]);
                        } elseif ($menuItem instanceof \App\Models\System\PageRoute) {
                            $route = localizedRoute($menuItem->route_name);
                        } else {
                            $route = $item->url ?: '#';
                        }
                        $hasChildren = $item->menuItems && $item->menuItems->count() > 0;
                    @endphp
                    @if($hasChildren)
                        <li class="nav-item dropdown">
                            <a class="nav-link px-4 text-dark-grey" href="#" id="vyrobkyDropdown" role="button" data-bs-toggle="dropdown">
                                {{ $item->title }}
                                <img src="{{ asset('assets/icons/select_icon.svg') }}" alt="Select" id="vyrobky-arrow" class="ms-1" style="height: 8px; transition: transform 0.3s ease;">
                            </a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link px-4 text-dark-grey" href="{{ $route }}">{{ $item->title }}</a>
                        </li>
                    @endif
                @endforeach
            </ul>

            {{-- Right: Language selector --}}
            <div class="d-flex align-items-center gap-3 me4-5">
                <livewire:system.language-select wire:key="header-lang-desktop" />
            </div>
        </div>
    </div>
</nav>

{{-- Mega submenu for items with children --}}
@foreach(($menuItems ?? collect()) as $item)
    @if($item->menuItems && $item->menuItems->count() > 0)
    <div id="submenu-level2" class="dropdown-menu-custom">
        <div class="dropdown-menu-bg">
            <div class="container-fw mx-0">
                <div class="submenu-content">
                    <div class="submenu-view">
                        <div class="category-header d-flex text-dark-grey justify-content-center">{{ $item->title }}</div>
                        <div class="grid-5 ms-70">
                            @foreach($item->menuItems as $child)
                                @php
                                    $childItem = $child?->linkable;
                                    if ($childItem instanceof \App\Models\PageRouteUrls) {
                                        $childRoute = localizedRoute($childItem->pageRoute->route_name, [data_get($childItem, 'slug')]);
                                    } elseif ($childItem instanceof \App\Models\System\PageRoute) {
                                        $childRoute = localizedRoute($childItem->route_name);
                                    } else {
                                        $childRoute = $child->url ?: '#';
                                    }
                                @endphp
                                <div>
                                    <a href="{{ $childRoute }}" class="text-decoration-none no-underline">
                                        <div class="product-category">
                                            <div class="product-title text-dark-grey">{{ $child->title }}</div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="submenu-switcher">
                        <div class="switcher-container gap-5 d-flex justify-content-end align-items-center me4-5">
                            <a href="mailto:obchod.project@mt3.cz" class="text-dark-grey fnt-size-125" style="text-decoration: none;">
                                Vaše preference <img src="{{ asset('assets/icons/obj_015.svg') }}" alt="" style="height: 1em; vertical-align: middle; margin-bottom:8px;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @break
    @endif
@endforeach

{{-- Blur overlay --}}
<div class="blur-overlay"></div>
