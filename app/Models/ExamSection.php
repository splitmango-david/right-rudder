<?php

namespace App\Models;

use Database\Factories\ExamSectionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['exam_id', 'key', 'name', 'short_name', 'position'])]
class ExamSection extends Model
{
    /** @use HasFactory<ExamSectionFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Exam, $this>
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * @return HasMany<Question, $this>
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('number');
    }

    public function displayName(): string
    {
        return $this->short_name ?? $this->name;
    }
}
