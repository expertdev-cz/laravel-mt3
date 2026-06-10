<div class="pb-10">
    @if(isset($news))
        @if($news->count() > 0)
            @if($isHp)
                <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                    @foreach ($news as $index => $item)
                        <div class="w-full {{ $index == 0 ? 'xl:col-span-2' : '' }}">
                            <article class="h-full overflow-hidden rounded-xl border border-slate-200 bg-white">
                                @if(!empty($item->content['image']))
                                    <a class="relative block aspect-[3/2] w-full overflow-hidden bg-slate-100"
                                        href="/{{ $mainSlug }}/{{ $item->slug }}">
                                        <x-curator-glider :media="$item->content['image']" class="absolute inset-0 h-full w-full object-cover" />
                                    </a>
                                @endif
                                <div class="space-y-3 p-4">
                                    <span class="inline-flex w-fit items-center rounded-full bg-slate-900 px-3 py-1 text-xs font-semibold text-white">
                                        @if($item->article_tags && $item->article_tags->count() > 0)
                                            {{ $item->article_tags->first()->name }}
                                        @else
                                            Blog
                                        @endif
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        {{ date('d. m. Y', strtotime($item->publish_time)) }}
                                    </span>
                                    <h3 class="text-lg font-bold text-slate-900">
                                        <a class="hover:text-primary" href="/{{ $mainSlug }}/{{ $item->slug }}">
                                            {{ $item->title }}
                                        </a>
                                    </h3>
                                    @if(in_array($index, [1,2]) && isset($item->content['text']))
                                        <p class="text-sm text-slate-600">
                                            {{ Str::limit(strip_tags($item->content['text']), 150) }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="flex flex-wrap justify-center">
                    @foreach ($news as $item)
                        <div class="w-full px-3 pb-6 md:w-1/2 xl:w-1/3">
                            <article class="h-full overflow-hidden rounded-xl border border-slate-200 bg-white">
                                @if(!empty($item->content['image']))
                                    <a class="relative block aspect-[3/2] w-full overflow-hidden bg-slate-100"
                                       href="/{{ $mainSlug }}/{{ $item->slug }}">
                                        <x-curator-glider :media="$item->content['image']" class="absolute inset-0 h-full w-full object-cover" />
                                    </a>
                                @endif
                                <div class="flex h-full flex-col space-y-3 p-4">
                                    <div class="flex flex-wrap gap-1">
                                        @if($item->article_tags && $item->article_tags->count() > 0)
                                            @foreach($item->article_tags as $tag)
                                                <span class="inline-flex items-center rounded-full bg-slate-900 px-2 py-1 text-[11px] font-semibold text-white">
                                                    {{ $tag->name }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="inline-flex items-center rounded-full bg-slate-900 px-2 py-1 text-[11px] font-semibold text-white">
                                                Článek
                                            </span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-slate-500">
                                        {{ date('d. m. Y', strtotime($item->publish_time)) }}
                                    </span>
                                    <h2 class="text-lg font-bold text-slate-900">
                                        <a class="hover:text-primary" href="/{{ $mainSlug }}/{{ $item->slug }}">
                                            {{ $item->title }}
                                        </a>
                                    </h2>
                                    @if(isset($item->content['text']))
                                        <p class="flex-1 text-sm text-slate-600">
                                            {{ Str::limit(strip_tags($item->content['text']), 150) }}
                                        </p>
                                    @endif
                                    <div>
                                        <a href="/{{ $mainSlug }}/{{ $item->slug }}" class="mt-auto text-xs font-bold uppercase tracking-wide text-slate-900 hover:text-primary">
                                            {{ __('Přečtěte si více') }}
                                        </a>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>
                @if(method_exists($news, 'links'))
                    <div class="mt-8 flex justify-center">
                        {{ $news->links('livewire.parts.pagination-articles') }}
                    </div>
                @endif
            @endif
        @else
            <div class="w-full text-center py-8">
                <p class="text-gray-500">Žádné články nebyly nalezeny.</p>
            </div>
        @endif
    @else
        <div class="w-full text-center py-8">
            <p class="text-gray-500">Načítám články...</p>
        </div>
    @endif
</div>