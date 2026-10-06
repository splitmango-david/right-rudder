<?php

namespace App\Models;

use Database\Factories\ReferenceMaterialFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['exam_id', 'key', 'title', 'text'])]
class ReferenceMaterial extends Model
{
    /** @use HasFactory<ReferenceMaterialFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Exam, $this>
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * @return HasMany<ReferenceImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(ReferenceImage::class)->orderBy('position');
    }

    /**
     * @return BelongsToMany<Question, $this>
     */
    public function questions(): BelongsToMany
    {
        return $this->belongsToMany(Question::class);
    }
}
