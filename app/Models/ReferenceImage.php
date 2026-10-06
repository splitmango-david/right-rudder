<?php

namespace App\Models;

use Database\Factories\ReferenceImageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

#[Fillable(['reference_material_id', 'label', 'path', 'position'])]
class ReferenceImage extends Model
{
    /** @use HasFactory<ReferenceImageFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<ReferenceMaterial, $this>
     */
    public function referenceMaterial(): BelongsTo
    {
        return $this->belongsTo(ReferenceMaterial::class);
    }

    public function url(): string
    {
        return Storage::disk('public')->url($this->path);
    }
}
