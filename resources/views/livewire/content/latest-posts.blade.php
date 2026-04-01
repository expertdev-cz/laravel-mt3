<div class="grid gap-8 md:grid-cols-3">
    @forelse ($news as $item)
        <div class="w-full">
            <article class="group flex h-full flex-col overflow-hidden rounded-xl border border-slate-200 bg-white">
                @if(!empty($item->content['image']))
                    <a class="relative block aspect-[3/2] w-full overflow-hidden bg-slate-100"
                       href="/{{ $mainSlug }}/{{ $item->slug }}">
                        <x-curator-glider :media="$item->content['image']" class="absolute inset-0 h-full w-full object-cover" />
                    </a>
                @endif
                <div class="flex flex-1 flex-col space-y-3 p-5">
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
                    @if(isset($item->content['text']))
                        <p class="flex-1 text-sm text-slate-600">
                            {{ strip_tags($item->getContentTextShort()) }}
                        </p>
                    @endif
                    <a href="/{{ $mainSlug }}/{{ $item->slug }}" class="mt-auto text-xs font-bold uppercase tracking-wide text-slate-900 hover:text-primary">
                        Přečtěte si více
                    </a>
                </div>
            </article>
        </div>
    @empty
        <div class="w-full text-center py-10">
            Žádné články nebyly nalezeny.
        </div>
    @endforelse
</div>
