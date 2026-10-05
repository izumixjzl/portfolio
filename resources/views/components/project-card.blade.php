@props(['project', 'large' => false])

<a href="{{ route('projects.show', $project) }}"
   class="group flex flex-col overflow-hidden rounded-2xl border border-line bg-raised transition hover:-translate-y-0.5 hover:border-ink/40">
    <div @class(['relative overflow-hidden border-b border-line bg-paper', 'aspect-[16/10]' => $large, 'aspect-[16/9]' => ! $large])>
        @if ($project->coverUrl())
            <img src="{{ $project->coverUrl() }}" alt="{{ $project->title }} screenshot"
                 loading="lazy"
                 class="h-full w-full object-cover transition duration-500 group-hover:scale-[1.02]">
        @else
            {{-- Placeholder until a cover image is uploaded --}}
            <div class="flex h-full w-full items-end p-6">
                <span class="font-display text-5xl leading-none text-line sm:text-6xl">{{ \Illuminate\Support\Str::of($project->title)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(3)->implode('') }}</span>
            </div>
        @endif
    </div>

    <div class="flex flex-1 flex-col gap-3 p-6">
        <div class="flex items-center justify-between gap-4">
            <p class="eyebrow">{{ collect([$project->year, $project->role])->filter()->implode(' · ') }}</p>
            <span class="text-soft transition group-hover:translate-x-1 group-hover:text-accent" aria-hidden="true">&rarr;</span>
        </div>
        <h3 @class(['font-display leading-tight', 'text-3xl' => $large, 'text-2xl' => ! $large])>{{ $project->title }}</h3>
        <p class="text-sm leading-relaxed text-soft">{{ $project->summary }}</p>

        @if (! empty($project->tech_stack))
            <div class="mt-auto flex flex-wrap gap-2 pt-2">
                @foreach (array_slice($project->tech_stack, 0, 5) as $tech)
                    <span class="tag">{{ $tech }}</span>
                @endforeach
            </div>
        @endif
    </div>
</a>
