<x-layouts.app title="Work" description="Projects and case studies by {{ config('portfolio.name') }}.">

    <section class="mx-auto max-w-6xl px-5 pt-16 pb-24 sm:px-8 md:pt-24">
        <p class="eyebrow">Work</p>
        <h1 class="mt-3 font-display text-5xl sm:text-7xl">All projects</h1>
        <p class="mt-5 max-w-xl text-soft">Each one has a short case study: the problem, what I built, and what I'd do differently.</p>

        @if ($techs->count() > 1)
            <nav class="mt-10 flex flex-wrap gap-2" aria-label="Filter by technology">
                <a href="{{ route('projects.index') }}"
                   @class(['rounded-full border px-3.5 py-1.5 text-sm transition', 'border-ink bg-ink text-paper' => ! $active, 'border-line hover:border-ink' => $active])
                   @if (! $active) aria-current="page" @endif>All</a>
                @foreach ($techs as $tech)
                    <a href="{{ route('projects.index', ['tech' => $tech]) }}"
                       @class(['rounded-full border px-3.5 py-1.5 text-sm transition', 'border-ink bg-ink text-paper' => $active === $tech, 'border-line hover:border-ink' => $active !== $tech])
                       @if ($active === $tech) aria-current="page" @endif>{{ $tech }}</a>
                @endforeach
            </nav>
        @endif

        @if ($active)
            <p class="mt-6 text-sm text-soft" role="status">
                {{ $projects->count() }} {{ Str::plural('project', $projects->count()) }} using {{ $active }}.
            </p>
        @endif

        @if ($projects->isEmpty())
            <p class="mt-12 text-soft">Nothing here yet.</p>
        @else
            <div @class(['grid gap-6 sm:grid-cols-2 lg:grid-cols-3', 'mt-14' => ! $active, 'mt-8' => $active])>
                @foreach ($projects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @endif
    </section>

</x-layouts.app>
