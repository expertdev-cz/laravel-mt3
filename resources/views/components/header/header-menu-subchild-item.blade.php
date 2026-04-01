<ul class="space-y-1">
@foreach($items as $item)
    <li>
        @php
            $menuItem = $item?->linkable;
            if ($menuItem instanceof \App\Models\PageRouteUrls) {
                $route = localizedRoute($menuItem->pageRoute->route_name, [data_get($menuItem, 'slug')]);
            } elseif ($menuItem instanceof \App\Models\System\PageRoute) {
                $route = localizedRoute($menuItem->route_name);
            } else {
                $route = $item->url;
            }
        @endphp
        <a class="block rounded px-2 py-1 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-slate-900" href="{{ $route }}">
            {{ $item->title }}
        </a>
    </li>
@endforeach
</ul>
