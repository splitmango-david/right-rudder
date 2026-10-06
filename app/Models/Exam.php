<?php

namespace App\Models;

use Database\Factories\ExamFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['slug', 'title', 'heading', 'category', 'reference', 'description', 'notes', 'pass_mark', 'external_chart_note', 'is_published'])]
class Exam extends Model
{
    /** @use HasFactory<ExamFactory> */
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pass_mark' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return HasMany<ExamSection, $this>
     */
    public function sections(): HasMany
    {
        return $this->hasMany(ExamSection::class)->orderBy('position');
    }

    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('number');
    }

    /**
     * @return HasMany<ReferenceMaterial, $this>
     */
    public function referenceMaterials(): HasMany
    {
        return $this->hasMany(ReferenceMaterial::class);
    }

    /**
     * @return HasMany<ExamAttempt, $this>
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(ExamAttempt::class);
    }

    /**
     * @param  Builder<Exam>  $query
     */
    public function scopePublished(Builder $query): void
    {
        $query->where('is_published', true);
    }
}
