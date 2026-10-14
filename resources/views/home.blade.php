<x-layouts.app>
    {{-- Structured data so search engines can show a richer result for your name --}}
    <x-slot:head>
        <script type="application/ld+json">
            {!! json_encode(array_filter([
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => config('portfolio.name'),
                'jobTitle' => config('portfolio.role'),
                'description' => config('portfolio.tagline'),
                'url' => route('home'),
                'email' => 'mailto:'.config('portfolio.email'),
                'address' => config('portfolio.location'),
                'sameAs' => array_values(array_filter([config('portfolio.github'), config('portfolio.linkedin')])),
            ]), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) !!}
        </script>
    </x-slot:head>

    {{-- Hero --}}
    <section class="mx-auto max-w-6xl px-5 pt-16 pb-20 sm:px-8 md:pt-28 md:pb-28">
        <p class="eyebrow flex items-center gap-2">
            <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-accent opacity-60"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-accent"></span>
            </span>
            {{ config('portfolio.role') }} · {{ config('portfolio.location') }}
        </p>

        <h1 class="mt-6 max-w-4xl font-display text-5xl leading-[1.02] tracking-tight sm:text-7xl md:text-8xl">
            Hi, I'm {{ config('portfolio.name') }}.
            <span class="text-soft">I build software that runs <em class="text-accent">real businesses</em>.</span>
        </h1>

        <p class="mt-8 max-w-2xl text-lg leading-relaxed text-soft">{{ config('portfolio.tagline') }}</p>

        <div class="mt-10 flex flex-wrap items-center gap-3">
            <a href="{{ route('projects.index') }}" class="btn-primary">See my work <span aria-hidden="true">&rarr;</span></a>
            @if (config('portfolio.resume_url'))
                <a href="{{ config('portfolio.resume_url') }}" class="btn-ghost" target="_blank" rel="noopener">Résumé</a>
            @endif
            @if (config('portfolio.github'))
                <a href="{{ config('portfolio.github') }}" class="btn-ghost" target="_blank" rel="noopener">GitHub</a>
            @endif
        </div>
    </section>

    {{-- Featured work --}}
    <section class="border-t border-line">
        <div class="mx-auto max-w-6xl px-5 py-20 sm:px-8 md:py-28">
            <div class="flex items-end justify-between gap-6">
                <div>
                    <p class="eyebrow">Selected work</p>
                    <h2 class="mt-3 font-display text-4xl sm:text-5xl">Things I've built</h2>
                </div>
                @if ($projectCount > $featured->count())
                    <a href="{{ route('projects.index') }}" class="link-underline hidden text-sm sm:inline">All {{ $projectCount }} projects &rarr;</a>
                @endif
            </div>

            @if ($featured->isEmpty())
                <p class="mt-10 text-soft">No projects yet — add your first one in <a class="link-underline" href="{{ url('/admin') }}">/admin</a>.</p>
            @else
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @foreach ($featured as $i => $project)
                        <div @class(['md:col-span-2' => $i === 0 && $featured->count() % 2 === 1])>
                            <x-project-card :project="$project" :large="$i === 0" />
                        </div>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('projects.index') }}" class="link-underline mt-10 inline-block text-sm sm:hidden">All projects &rarr;</a>
        </div>
    </section>

    {{-- About + skills --}}
    <section id="about" class="border-t border-line bg-raised">
        <div class="mx-auto grid max-w-6xl gap-14 px-5 py-20 sm:px-8 md:grid-cols-5 md:py-28">
            <div class="md:col-span-2">
                <p class="eyebrow">About</p>
                <h2 class="mt-3 font-display text-4xl sm:text-5xl">How I work</h2>
                <p class="mt-6 leading-relaxed text-soft">{{ config('portfolio.about') }}</p>
            </div>

            <div class="md:col-span-3">
                <dl class="divide-y divide-line border-y border-line">
                    @forelse ($skills as $category => $items)
                        <div class="grid gap-3 py-5 sm:grid-cols-3">
                            <dt class="eyebrow pt-1">{{ \App\Models\Skill::CATEGORIES[$category] ?? $category }}</dt>
                            <dd class="flex flex-wrap gap-2 sm:col-span-2">
                                @foreach ($items as $skill)
                                    <span class="rounded-full bg-paper px-3 py-1.5 text-sm">{{ $skill->name }}</span>
                                @endforeach
                            </dd>
                        </div>
                    @empty
                        <p class="py-5 text-soft">Add skills in /admin.</p>
                    @endforelse
                </dl>
            </div>
        </div>
    </section>

    @include('partials.contact')

</x-layouts.app>
