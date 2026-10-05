<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Skill;
use Illuminate\Database\Seeder;

/**
 * Starter content so the site isn't empty on first run.
 * Edit or replace all of it from /admin.
 */
class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Beauty Lounge Management System',
                'summary' => 'Appointments, services, staff and sales for a beauty lounge — an ASP.NET Core API with a WinForms desktop client.',
                'role' => 'Full-stack developer',
                'year' => '2026',
                'tech_stack' => ['C#', 'ASP.NET Core', 'WinForms', 'Entity Framework Core', 'SQL Server'],
                'is_featured' => true,
                'sort_order' => 1,
                'description' => <<<'MD'
## The problem
Replace this with the real story: how the lounge handled bookings and sales before, and what kept going wrong.

## What I built
- A REST API in **ASP.NET Core** that owns the business rules (bookings, services, staff, payments)
- A **WinForms** desktop app the front desk uses all day
- A relational schema designed around appointments and transactions

## Architecture
Describe how the desktop client talks to the API, how authentication works, and how the data is structured. A simple diagram screenshot works well here.

## What I'd improve next
Be honest — reviewers like seeing that you know the trade-offs you made.
MD,
            ],
            [
                'title' => 'Developer Portfolio',
                'summary' => 'This site — a Laravel app with a Filament admin panel so projects are managed without touching code.',
                'role' => 'Solo developer',
                'year' => '2026',
                'tech_stack' => ['Laravel', 'Filament', 'Blade', 'Tailwind CSS', 'SQLite'],
                'is_featured' => true,
                'sort_order' => 2,
                'repo_url' => config('portfolio.github'),
                'description' => <<<'MD'
## Why build it this way
Instead of a static template, the portfolio is a small content-managed app: projects, skills and contact messages all live in the database and are edited from an admin panel.

## Highlights
- Filament admin with image uploads and a contact-message inbox
- Rate-limited contact form with spam honeypot
- Markdown case studies rendered safely
MD,
            ],
            [
                'title' => 'Another Project',
                'summary' => 'Placeholder — swap this for a school, freelance or personal project you are proud of.',
                'role' => 'Developer',
                'year' => '2025',
                'tech_stack' => ['PHP', 'MySQL'],
                'sort_order' => 3,
                'description' => "## Overview\nDescribe the problem, what you built, and the result.",
            ],
        ];

        foreach ($projects as $data) {
            Project::updateOrCreate(['title' => $data['title']], $data);
        }

        $skills = [
            'Backend' => ['C#', 'ASP.NET Core', 'PHP', 'Laravel', 'REST APIs'],
            'Desktop' => ['WinForms'],
            'Frontend' => ['HTML & CSS', 'JavaScript', 'Tailwind CSS', 'Blade'],
            'Database' => ['SQL Server', 'MySQL', 'Entity Framework Core', 'Eloquent'],
            'Tools' => ['Git & GitHub', 'Visual Studio', 'Postman'],
        ];

        foreach ($skills as $category => $names) {
            foreach ($names as $i => $name) {
                Skill::updateOrCreate(
                    ['name' => $name, 'category' => $category],
                    ['sort_order' => $i],
                );
            }
        }
    }
}
