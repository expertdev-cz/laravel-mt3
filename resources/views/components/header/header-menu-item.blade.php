
<li class="relative" data-has-submenu="{{ (bool) $item->children->count() >= 1 }}">
    @php
        $menuItem = $item?->linkable;
        if ($menuItem instanceof \App\Models\PageRouteUrls) {
            $route = localizedRoute($menuItem->pageRoute->route_name, [data_get($menuItem, 'slug')]);
        } elseif ($menuItem instanceof \App\Models\System\PageRoute) {
            $route = localizedRoute($menuItem->route_name);
        } else {
            $route = $item->url;
        }

        $hasChildren = (bool) $item->children->count() >= 1;
    @endphp
    <a
        href="{{ $route }}"
        @if($hasChildren) id="servicesMenuItem" @endif
        class="inline-flex items-center gap-1 rounded-md px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 hover:text-slate-900"
    >
        {{ $item->title }}
        @if($hasChildren)
            <span class="text-xs text-slate-500" aria-hidden="true">v</span>
        @endif
    </a>
</li>
@if($hasChildren)
    @include('components.header.header-menu-child-item', ['items' => $item->children])
@endif

