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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->cascadeOnDelete();
            $table->foreignId('exam_section_id')->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('number');
            $table->text('stem');
            $table->json('options');
            $table->unsignedTinyInteger('correct_option');
            $table->boolean('requires_external_chart')->default(false);
            $table->timestamps();

            $table->unique(['exam_id', 'number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
