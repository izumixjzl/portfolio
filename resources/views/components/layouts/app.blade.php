@props(['title' => null, 'description' => null])

@php
    $siteName = config('portfolio.name');
    $pageTitle = $title ? "{$title} — {$siteName}" : "{$siteName} · ".config('portfolio.role');
    $metaDescription = $description ?? config('portfolio.tagline');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">

    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    {{ $head ?? '' }}

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600|instrument-serif:400,400i|jetbrains-mono:400" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans">

    <header class="sticky top-0 z-40 border-b border-line/70 bg-paper/85 backdrop-blur">
        <nav class="mx-auto flex max-w-6xl items-center justify-between px-5 py-4 sm:px-8">
            <a href="{{ route('home') }}" class="font-display text-2xl leading-none">
                {{ $siteName }}<span class="text-accent">.</span>
            </a>
            <div class="flex items-center gap-5 text-sm sm:gap-7">
                <a href="{{ route('projects.index') }}" @class(['hover:text-accent transition', 'text-accent' => request()->routeIs('projects.*')])>Work</a>
                <a href="{{ route('home') }}#about" class="hidden transition hover:text-accent sm:inline">About</a>
                <a href="{{ route('home') }}#contact" class="btn-primary px-4! py-2!">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto flex max-w-6xl flex-col gap-4 px-5 py-10 text-sm text-soft sm:flex-row sm:items-center sm:justify-between sm:px-8">
            <p>&copy; {{ now()->year }} {{ $siteName }} · Built with Laravel &amp; Filament</p>
            <div class="flex gap-5">
                @if (config('portfolio.github'))
                    <a class="link-underline" href="{{ config('portfolio.github') }}" target="_blank" rel="noopener">GitHub</a>
                @endif
                @if (config('portfolio.linkedin'))
                    <a class="link-underline" href="{{ config('portfolio.linkedin') }}" target="_blank" rel="noopener">LinkedIn</a>
                @endif
                <a class="link-underline" href="mailto:{{ config('portfolio.email') }}">Email</a>
            </div>
        </div>
    </footer>
</body>
</html>
