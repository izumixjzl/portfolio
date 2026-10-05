<x-layouts.app :title="$project->title" :description="$project->summary">
    @if ($project->coverUrl())
        <x-slot:head>
            <meta property="og:image" content="{{ $project->coverUrl() }}">
        </x-slot:head>
    @endif

    <article>
        <header class="mx-auto max-w-4xl px-5 pt-14 sm:px-8 md:pt-20">
            <a href="{{ route('projects.index') }}" class="eyebrow transition hover:text-accent">&larr; All work</a>

            <h1 class="mt-6 font-display text-5xl leading-[1.05] tracking-tight sm:text-7xl">{{ $project->title }}</h1>
            <p class="mt-6 max-w-2xl text-xl leading-relaxed text-soft">{{ $project->summary }}</p>

            <dl class="mt-10 grid grid-cols-2 gap-6 border-y border-line py-6 text-sm sm:grid-cols-4">
                @if ($project->role)
                    <div><dt class="eyebrow">Role</dt><dd class="mt-1.5">{{ $project->role }}</dd></div>
                @endif
                @if ($project->year)
                    <div><dt class="eyebrow">Year</dt><dd class="mt-1.5">{{ $project->year }}</dd></div>
                @endif
                @if ($project->repo_url)
                    <div><dt class="eyebrow">Code</dt><dd class="mt-1.5"><a class="link-underline" href="{{ $project->repo_url }}" target="_blank" rel="noopener">View repo &nearr;</a></dd></div>
                @endif
                @if ($project->live_url)
                    <div><dt class="eyebrow">Live</dt><dd class="mt-1.5"><a class="link-underline" href="{{ $project->live_url }}" target="_blank" rel="noopener">Open demo &nearr;</a></dd></div>
                @endif
            </dl>

            @if (! empty($project->tech_stack))
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($project->tech_stack as $tech)
                        <span class="tag">{{ $tech }}</span>
                    @endforeach
                </div>
            @endif
        </header>

        @if ($project->coverUrl())
            <figure class="mx-auto mt-12 max-w-6xl px-5 sm:px-8">
                <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }}" class="w-full rounded-2xl border border-line">
            </figure>
        @endif

        @if ($project->description)
            <div class="prose-case mx-auto max-w-3xl px-5 py-10 sm:px-8">
                {!! $project->descriptionHtml() !!}
            </div>
        @endif

        @if ($gallery = $project->galleryUrls())
            <section class="mx-auto max-w-6xl px-5 pb-16 sm:px-8">
                <p class="eyebrow mb-6">Screenshots</p>
                <div class="grid gap-5 sm:grid-cols-2">
                    @foreach ($gallery as $src)
                        <a href="{{ $src }}" target="_blank" rel="noopener" class="block overflow-hidden rounded-xl border border-line">
                            <img src="{{ $src }}" alt="{{ $project->title }} screenshot {{ $loop->iteration }}" loading="lazy" class="w-full transition duration-500 hover:scale-[1.02]">
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </article>

    @if ($others->isNotEmpty())
        <section class="border-t border-line">
            <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8">
                <p class="eyebrow">More work</p>
                <div class="mt-8 grid gap-6 md:grid-cols-2">
                    @foreach ($others as $other)
                        <x-project-card :project="$other" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @include('partials.contact')

</x-layouts.app>
