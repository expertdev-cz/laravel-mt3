<div class="pointer-events-none absolute left-0 top-full z-50 hidden w-[44rem] pt-2 group-hover:block">
    <nav
        id="servicesSubmenu"
        class="pointer-events-auto rounded-xl border border-slate-200 bg-white p-4 shadow-xl"
        aria-labelledby="servicesMenuItem"
        aria-hidden="true"
    >
        <div class="grid gap-4 sm:grid-cols-2">
            @foreach($items as $item)
                <div class="rounded-lg border border-slate-100 p-3">
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

                    <a href="{{ $route }}" class="mb-2 block text-sm font-bold text-slate-900 hover:text-primary">
                        {{ $item->title }}
                    </a>

                    @if($item->children && $item->children->count())
                        @include('components.header.header-menu-subchild-item', ['items' => $item->children])
                    @endif
                </div>
            @endforeach
        </div>
    </nav>
</div>
