<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    protected $fillable = [
        'title', 'slug', 'summary', 'description', 'role', 'year',
        'tech_stack', 'cover_image', 'gallery', 'repo_url', 'live_url',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'gallery' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        // Fill the slug from the title when it's left blank.
        static::saving(function (Project $project) {
            if (blank($project->slug)) {
                $base = Str::slug($project->title);
                $slug = $base;
                $i = 2;
                while (static::where('slug', $slug)->whereKeyNot($project->getKey())->exists()) {
                    $slug = "{$base}-{$i}";
                    $i++;
                }
                $project->slug = $slug;
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderByDesc('created_at');
    }

    public function coverUrl(): ?string
    {
        return $this->imageUrl($this->cover_image);
    }

    /** @return array<int, string> */
    public function galleryUrls(): array
    {
        return collect($this->gallery ?? [])
            ->map(fn ($path) => $this->imageUrl($path))
            ->filter()
            ->values()
            ->all();
    }

    public function descriptionHtml(): string
    {
        return Str::markdown($this->description ?? '', [
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);
    }

    private function imageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        // Allow full URLs (e.g. images hosted elsewhere) as well as uploads.
        return Str::startsWith($path, ['http://', 'https://'])
            ? $path
            : Storage::disk('public')->url($path);
    }
}
