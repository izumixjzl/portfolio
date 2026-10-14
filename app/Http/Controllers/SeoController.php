<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        $projects = Project::published()->ordered()->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', [
                'projects' => $projects,
                'lastModified' => $projects->max('updated_at'),
            ])
            ->header('Content-Type', 'application/xml');
    }

    // Served from a route (not public/robots.txt) so the sitemap URL follows APP_URL.
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            '',
            'Sitemap: '.route('sitemap'),
        ];

        return response(implode("\n", $lines)."\n")
            ->header('Content-Type', 'text/plain');
    }
}
