<section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
    @if(!$isAuthenticated)
        <p class="text-sm text-slate-600">Obsah autorizovaného přístupu je dostupný až po přihlášení.</p>
    @elseif($folders->isEmpty())
        <p class="text-sm text-slate-600">Zatím nejsou k dispozici žádné složky.</p>
    @else
        <div class="grid gap-5 md:grid-cols-3">
            @foreach($folders as $folder)
                <article class="rounded-2xl border border-slate-200 p-5">
                    <h2 class="text-xl font-semibold text-slate-900">{{ $folder->title }}</h2>
                    @if($folder->description)
                        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $folder->description }}</p>
                    @endif
                </article>
            @endforeach
        </div>
    @endif
</section>