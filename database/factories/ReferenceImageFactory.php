<?php

namespace Database\Factories;

use App\Models\ReferenceImage;
use App\Models\ReferenceMaterial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ReferenceImage>
 */
class ReferenceImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'reference_material_id' => ReferenceMaterial::factory(),
            'label' => null,
            'path' => 'references/'.fake()->uuid().'.jpg',
            'position' => 0,
        ];
    }
}
