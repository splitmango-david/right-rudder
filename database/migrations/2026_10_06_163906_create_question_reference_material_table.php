<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // An earlier version of this migration failed on MySQL after creating the table
        // (the auto-generated index name exceeded 64 characters), leaving an empty,
        // unrecorded table behind. Clear it so the migration can run cleanly.
        Schema::dropIfExists('question_reference_material');

        Schema::create('question_reference_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reference_material_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);

            $table->unique(['question_id', 'reference_material_id'], 'question_reference_material_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('question_reference_material');
    }
};
