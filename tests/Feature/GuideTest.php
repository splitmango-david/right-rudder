<?php

namespace Tests\Feature;

use App\Models\Exam;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuideTest extends TestCase
{
    use RefreshDatabase;

    public function test_every_configured_guide_renders(): void
    {
        foreach (config('guides') as $slug => $guide) {
            $this->get(route('guides.show', $slug))
                ->assertOk()
                ->assertSee($guide['heading']);
        }
    }

    public function test_unknown_guide_returns_not_found(): void
    {
        $this->get('/guides/not-a-guide')->assertNotFound();
    }

    public function test_home_page_lists_exams_and_guides(): void
    {
        Exam::factory()->create(['title' => 'Visible Exam']);

        $response = $this->get(route('home'))->assertOk()->assertSee('Visible Exam');

        foreach (config('guides') as $slug => $guide) {
            $response->assertSee($guide['title'])->assertSee(route('guides.show', $slug));
        }
    }
}
