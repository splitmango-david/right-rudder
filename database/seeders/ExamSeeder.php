<?php

namespace Database\Seeders;

use App\Models\Exam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ExamSeeder extends Seeder
{
    /**
     * Each directory in database/data holds one exam: an exam.json plus its reference images.
     * Re-running is safe; exams are matched by slug and their content is rebuilt.
     */
    public function run(): void
    {
        foreach (File::directories(database_path('data')) as $directory) {
            $this->seedExam($directory);
        }
    }

    private function seedExam(string $directory): void
    {
        $data = File::json("{$directory}/exam.json");

        DB::transaction(function () use ($data, $directory) {
            $exam = Exam::updateOrCreate(['slug' => $data['slug']], [
                'title' => $data['title'],
                'heading' => $data['heading'],
                'category' => $data['category'],
                'reference' => $data['reference'],
                'description' => $data['description'],
                'notes' => $data['notes'],
                'pass_mark' => $data['pass_mark'],
                'external_chart_note' => $data['external_chart_note'],
            ]);

            $exam->sections()->delete();
            $exam->referenceMaterials()->delete();
            Storage::disk('public')->deleteDirectory("references/{$exam->slug}");

            $referenceIds = [];

            foreach ($data['references'] as $referenceData) {
                $reference = $exam->referenceMaterials()->create([
                    'key' => $referenceData['key'],
                    'title' => $referenceData['title'],
                    'text' => $referenceData['text'],
                ]);

                foreach ($referenceData['images'] as $position => $imageData) {
                    $path = "references/{$exam->slug}/{$imageData['file']}";
                    Storage::disk('public')->put($path, File::get("{$directory}/images/{$imageData['file']}"));

                    $reference->images()->create([
                        'label' => $imageData['label'],
                        'path' => $path,
                        'position' => $position,
                    ]);
                }

                $referenceIds[$reference->key] = $reference->id;
            }

            $questionsBySection = collect($data['questions'])->keyBy('number');

            foreach ($data['sections'] as $position => $sectionData) {
                $section = $exam->sections()->create([
                    'key' => $sectionData['key'],
                    'name' => $sectionData['name'],
                    'short_name' => $sectionData['short_name'],
                    'position' => $position,
                ]);

                foreach (range($sectionData['first'], $sectionData['last']) as $number) {
                    $questionData = $questionsBySection[$number];

                    $question = $section->questions()->create([
                        'exam_id' => $exam->id,
                        'number' => $number,
                        'stem' => $questionData['stem'],
                        'options' => $questionData['options'],
                        'correct_option' => $questionData['correct_option'],
                        'requires_external_chart' => $questionData['requires_external_chart'],
                    ]);

                    $question->referenceMaterials()->attach(
                        collect($questionData['references'])
                            ->mapWithKeys(fn ($key, $position) => [$referenceIds[$key] => ['position' => $position]])
                            ->all()
                    );
                }
            }
        });
    }
}
