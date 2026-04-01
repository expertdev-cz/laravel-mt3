@php
    $menuItem = $item?->linkable;
    if ($menuItem instanceof \App\Models\PageRouteUrls) {
        $route = localizedRoute($menuItem->pageRoute->route_name, [$menuItem->slug]);
    } elseif ($menuItem instanceof \App\Models\System\PageRoute) {
        $route = localizedRoute($menuItem->route_name);
    } else {
        $route = $item->url ?: '#';
    }

    $hasChildren = $item->children && $item->children->count() > 0;
@endphp

<li class="border-b border-slate-200 py-1 last:border-b-0">
    @if($hasChildren)
        <details>
            <summary class="flex cursor-pointer list-none items-center justify-between rounded px-2 py-2 text-sm font-medium text-slate-800 hover:bg-slate-100">
                <span>{{ $item->title }}</span>
                <span class="text-slate-500">+</span>
            </summary>

            <ul class="space-y-1 pl-3 pt-1">
                <li>
                    <a href="{{ $route }}" class="block rounded px-2 py-2 text-sm text-slate-700 hover:bg-slate-100">Prejit na {{ $item->title }}</a>
                </li>
                @foreach($item->children as $child)
                    @include('components.header.header-menu-mobile-item', ['item' => $child])
                @endforeach
            </ul>
        </details>
    @else
        <a href="{{ $route }}" class="block rounded px-2 py-2 text-sm font-medium text-slate-800 hover:bg-slate-100">{{ $item->title }}</a>
    @endif
</li>
