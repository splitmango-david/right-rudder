<?php

namespace Tests\Feature;

use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\ReferenceImage;
use Database\Seeders\ExamSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ExamSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeds_the_ppl_sample_exam_with_reference_images(): void
    {
        Storage::fake('public');

        $this->seed(ExamSeeder::class);

        $exam = Exam::where('slug', 'ppl-sample')->sole();
        $this->assertSame(100, $exam->questions()->count());
        $this->assertSame(['law', 'gen', 'met', 'nav'], $exam->sections->pluck('key')->all());
        $this->assertSame(12, ReferenceImage::count());
        ReferenceImage::all()->each(fn ($image) => Storage::disk('public')->assertExists($image->path));
    }

    public function test_reseeding_rebuilds_content_and_keeps_attempts(): void
    {
        Storage::fake('public');

        $this->seed(ExamSeeder::class);
        $attempt = ExamAttempt::factory()->for(Exam::sole())->create();
        $this->seed(ExamSeeder::class);

        $this->assertSame(1, Exam::count());
        $this->assertSame(100, Exam::sole()->questions()->count());
        $this->assertModelExists($attempt);
    }
}
