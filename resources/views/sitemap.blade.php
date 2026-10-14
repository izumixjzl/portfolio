{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc>{{ route('home') }}</loc>
        @if ($lastModified)<lastmod>{{ $lastModified->toAtomString() }}</lastmod>@endif
    </url>
    <url>
        <loc>{{ route('projects.index') }}</loc>
        @if ($lastModified)<lastmod>{{ $lastModified->toAtomString() }}</lastmod>@endif
    </url>
    @foreach ($projects as $project)
        <url>
            <loc>{{ route('projects.show', $project) }}</loc>
            <lastmod>{{ $project->updated_at->toAtomString() }}</lastmod>
        </url>
    @endforeach
</urlset>
