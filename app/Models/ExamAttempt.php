<?php

namespace App\Models;

use Database\Factories\ExamAttemptFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'exam_id', 'user_id', 'session_id', 'section_keys', 'answers', 'flags', 'section_results',
    'correct_count', 'question_count', 'score', 'passed', 'started_at', 'submitted_at',
])]
class ExamAttempt extends Model
{
    /** @use HasFactory<ExamAttemptFactory> */
    use HasFactory, HasUlids;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'section_keys' => 'array',
            'answers' => 'array',
            'flags' => 'array',
            'section_results' => 'array',
            'correct_count' => 'integer',
            'question_count' => 'integer',
            'score' => 'integer',
            'passed' => 'boolean',
            'started_at' => 'datetime',
            'submitted_at' => 'datetime',
        ];
    }

    /**
     * Use the public ULID column, not the auto-increment id, in URLs.
     *
     * @return list<string>
     */
    public function uniqueIds(): array
    {
        return ['ulid'];
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }

    /**
     * @return BelongsTo<Exam, $this>
     */
    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function answerFor(int $questionNumber): ?int
    {
        return $this->answers[$questionNumber] ?? null;
    }

    public function isFlagged(int $questionNumber): bool
    {
        return in_array($questionNumber, $this->flags, true);
    }
}
