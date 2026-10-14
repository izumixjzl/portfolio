<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Http\Request;
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

    public function projects(Request $request): View
    {
        $all = Project::published()->ordered()->get();

        // Every technology used across published projects, most common first.
        $techs = $all->pluck('tech_stack')->flatten()->filter()
            ->countBy()->sortDesc()->keys();

        // ?tech=Laravel narrows the list; unknown values just show everything.
        $active = $techs->first(fn ($tech) => strcasecmp($tech, (string) $request->query('tech')) === 0);

        $projects = $active
            ? $all->filter(fn ($p) => in_array($active, $p->tech_stack ?? [], true))->values()
            : $all;

        return view('projects.index', compact('projects', 'techs', 'active'));
    }

    public function show(Project $project): View
    {
        abort_unless($project->is_published, 404);

        // Previous / next follow the same order as the Work page, wrapping around.
        $all = Project::published()->ordered()->get();
        $index = $all->search(fn ($p) => $p->is($project));
        $count = $all->count();

        $previous = $count > 1 ? $all[($index - 1 + $count) % $count] : null;
        $next = $count > 1 ? $all[($index + 1) % $count] : null;

        // With exactly two projects, both directions point at the same one.
        if ($previous?->is($next)) {
            $previous = null;
        }

        return view('projects.show', compact('project', 'previous', 'next'));
    }

    private function groupedSkills()
    {
        $order = array_keys(Skill::CATEGORIES);

        return Skill::orderBy('sort_order')->orderBy('name')->get()
            ->groupBy('category')
            ->sortBy(fn ($_, $category) => array_search($category, $order) === false ? 99 : array_search($category, $order));
    }
}
