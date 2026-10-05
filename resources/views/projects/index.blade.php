<x-layouts.app title="Work" description="Projects and case studies by {{ config('portfolio.name') }}.">

    <section class="mx-auto max-w-6xl px-5 pt-16 pb-24 sm:px-8 md:pt-24">
        <p class="eyebrow">Work</p>
        <h1 class="mt-3 font-display text-5xl sm:text-7xl">All projects</h1>
        <p class="mt-5 max-w-xl text-soft">Each one has a short case study: the problem, what I built, and what I'd do differently.</p>

        @if ($projects->isEmpty())
            <p class="mt-12 text-soft">Nothing here yet.</p>
        @else
            <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    <x-project-card :project="$project" />
                @endforeach
            </div>
        @endif
    </section>

</x-layouts.app>
