<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    public function home(): View
    {
        $featured = Project::published()->where('is_featured', true)->ordered()->take(4)->get();

        // Fall back to the newest projects if nothing is marked featured yet.
        if ($featured->isEmpty()) {
            $featured = Project::published()->ordered()->take(4)->get();
        }

        return view('home', [
            'featured' => $featured,
            'projectCount' => Project::published()->count(),
            'skills' => $this->groupedSkills(),
        ]);
    }

    public function projects(): View
    {
        return view('projects.index', [
            'projects' => Project::published()->ordered()->get(),
        ]);
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        $others = Project::published()
            ->whereKeyNot($project->getKey())
            ->ordered()
            ->take(2)
            ->get();

        return view('projects.show', compact('project', 'others'));
    }

    private function groupedSkills()
    {
        $order = array_keys(Skill::CATEGORIES);

        return Skill::orderBy('sort_order')->orderBy('name')->get()
            ->groupBy('category')
            ->sortBy(fn ($_, $category) => array_search($category, $order) === false ? 99 : array_search($category, $order));
    }
}
