<?php

namespace App\Models;

use Database\Factories\QuestionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable(['exam_id', 'exam_section_id', 'number', 'stem', 'options', 'correct_option', 'requires_external_chart'])]
#[Hidden(['correct_option'])]
class Question extends Model
{
    /** @use HasFactory<QuestionFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'options' => 'array',
            'number' => 'integer',
            'correct_option' => 'integer',
            'requires_external_chart' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<Exam, $this>
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * @return BelongsTo<ExamSection, $this>
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(ExamSection::class, 'exam_section_id');
    }

    /**
     * @return BelongsToMany<ReferenceMaterial, $this>
     */
    public function referenceMaterials(): BelongsToMany
    {
        return $this->belongsToMany(ReferenceMaterial::class)->withPivot('position')->orderByPivot('position');
    }
}
