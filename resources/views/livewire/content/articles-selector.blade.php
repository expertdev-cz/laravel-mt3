<ul class="flex flex-wrap items-center justify-center gap-2.5 mb-5">
    @foreach($tags as $tag)
        <li>
            <a wire:click="changeTag('{{$tag->id}}')" link="#basics" class="filter-btn flex items-center justify-center gap-x-2 text-[13px] md:text-sm xl:text-[15px] px-3 xl:px-4 py-2.5 xl:py-3 text-color-quaternary hover:bg-[#1D71C9] hover:text-white bg-[#F0F2F4] rounded-[50px] group font-bold uppercase newsfilterbtn">
                <img src="assets/images/icons/catalog/icon1.svg" alt="" class="group-hover:hidden">
                <img src="assets/images/icons/catalog/icon1-white.svg" alt="" class="hidden group-hover:block">
                {{$tag->name}}
            </a>
        </li>
    @endforeach
</ul>
