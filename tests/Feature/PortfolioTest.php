<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    private function project(string $title, array $attributes = []): Project
    {
        return Project::create($attributes + [
            'title' => $title,
            'summary' => "Summary of {$title}",
            'tech_stack' => ['Laravel'],
        ]);
    }

    public function test_home_page_shows_featured_projects_and_structured_data(): void
    {
        $this->project('Shop System', ['is_featured' => true]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Shop System')
            ->assertSee('application/ld+json', false)
            ->assertSee('<link rel="canonical"', false);
    }

    public function test_unpublished_projects_are_hidden(): void
    {
        $draft = $this->project('Secret Draft', ['is_published' => false]);

        $this->get('/projects')->assertOk()->assertDontSee('Secret Draft');
        $this->get(route('projects.show', $draft))->assertNotFound();
    }

    public function test_projects_can_be_filtered_by_technology(): void
    {
        $this->project('Laravel App', ['tech_stack' => ['Laravel', 'MySQL']]);
        $this->project('Dotnet App', ['tech_stack' => ['C#', 'SQL Server']]);

        $this->get('/projects?tech=laravel')
            ->assertOk()
            ->assertSee('Laravel App')
            ->assertDontSee('Dotnet App')
            ->assertSee('1 project using Laravel');

        // An unknown technology falls back to showing everything.
        $this->get('/projects?tech=Cobol')
            ->assertOk()
            ->assertSee('Laravel App')
            ->assertSee('Dotnet App');
    }

    public function test_case_study_links_to_previous_and_next_projects(): void
    {
        $first = $this->project('First', ['sort_order' => 1]);
        $this->project('Second', ['sort_order' => 2]);
        $this->project('Third', ['sort_order' => 3]);

        // From the first project, "previous" wraps around to the last one.
        $this->get(route('projects.show', $first))
            ->assertOk()
            ->assertSeeInOrder(['Previous project', 'Third', 'Next project', 'Second']);
    }

    public function test_single_project_has_no_prev_next_section(): void
    {
        $only = $this->project('Only One');

        $this->get(route('projects.show', $only))
            ->assertOk()
            ->assertDontSee('Next project');
    }

    public function test_sitemap_lists_published_projects_only(): void
    {
        $this->project('Public Thing');
        $this->project('Hidden Thing', ['is_published' => false]);

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee(route('projects.show', 'public-thing'), false)
            ->assertDontSee('hidden-thing');
    }

    public function test_robots_points_to_sitemap(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap: '.route('sitemap'));
    }

    public function test_contact_form_saves_message(): void
    {
        $this->post('/contact', [
            'name' => 'Ana',
            'email' => 'ana@example.com',
            'message' => 'Hello, I would like to work with you.',
        ])->assertRedirect()->assertSessionHas('contact_sent');

        $this->assertDatabaseHas('contact_messages', ['email' => 'ana@example.com']);
    }

    public function test_contact_form_honeypot_discards_bots(): void
    {
        $this->post('/contact', [
            'name' => 'Bot',
            'email' => 'bot@example.com',
            'message' => 'Buy cheap things now!!!',
            'website' => 'http://spam.example',
        ])->assertSessionHas('contact_sent');

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_contact_form_errors_are_linked_to_fields(): void
    {
        $this->from('/')->followingRedirects()
            ->post('/contact', ['name' => '', 'email' => 'not-an-email', 'message' => 'short'])
            ->assertSee('aria-describedby="email-error"', false)
            ->assertSee('id="email-error"', false);
    }
}
