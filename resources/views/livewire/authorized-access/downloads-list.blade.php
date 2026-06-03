<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    @if(!$isAuthenticated)
        <p class="text-sm text-slate-600">Technické listy jsou dostupné až po přihlášení.</p>
    @elseif($folders->isEmpty())
        <p class="text-sm text-slate-600">Zatím zde nejsou žádné složky ani soubory ke stažení.</p>
    @else
        <div class="space-y-8">
            @foreach($folders as $folder)
                <section>
                    <h2 class="text-2xl font-semibold text-slate-900">{{ $folder->title }}</h2>
                    @if($folder->description)
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $folder->description }}</p>
                    @endif

                    <div class="mt-4 overflow-hidden rounded-2xl border border-slate-200">
                        @forelse($folder->downloads as $download)
                            <div class="grid gap-3 border-b border-slate-200 px-5 py-4 md:grid-cols-[180px,1fr,auto] md:items-center last:border-b-0">
                                <div class="text-sm font-medium text-slate-500">{{ $download->code }}</div>
                                <div>
                                    <p class="font-medium text-slate-900">{{ $download->title }}</p>
                                    @if($download->description)
                                        <p class="mt-1 text-sm text-slate-600">{{ $download->description }}</p>
                                    @endif
                                </div>
                                @if($download->file)
                                    <a href="{{ asset('storage/' . $download->file) }}" class="inline-flex rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-700" target="_blank" rel="noopener">Stáhnout</a>
                                @endif
                            </div>
                        @empty
                            <div class="px-5 py-4 text-sm text-slate-600">V této složce zatím nejsou žádné soubory.</div>
                        @endforelse
                    </div>
                </section>
            @endforeach
        </div>
    @endif
</section>