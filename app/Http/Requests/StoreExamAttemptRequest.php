<?php

namespace App\Http\Requests;

use App\Models\Exam;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreExamAttemptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Exam $exam */
        $exam = $this->route('exam');

        return [
            'sections' => ['required', 'array', 'min:1'],
            'sections.*' => ['string', 'distinct', Rule::in($exam->sections()->pluck('key'))],
            'answers' => ['present', 'array'],
            'answers.*' => ['integer', 'between:1,4'],
            'flags' => ['present', 'array'],
            'flags.*' => ['integer'],
            'started_at' => ['required', 'integer'],
        ];
    }

    /**
     * Section keys in the exam's own order.
     *
     * @return list<string>
     */
    public function sectionKeys(): array
    {
        /** @var Exam $exam */
        $exam = $this->route('exam');

        return $exam->sections()->whereIn('key', $this->validated('sections'))->pluck('key')->all();
    }

    /**
     * Answers keyed by question number, limited to questions in this exam.
     *
     * @return array<int, int>
     */
    public function answers(): array
    {
        /** @var Exam $exam */
        $exam = $this->route('exam');
        $questionNumbers = $exam->questions()->pluck('number')->all();

        return collect($this->validated('answers'))
            ->mapWithKeys(fn ($option, $number) => [(int) $number => (int) $option])
            ->only($questionNumbers)
            ->sortKeys()
            ->all();
    }

    /**
     * @return list<int>
     */
    public function flags(): array
    {
        return collect($this->validated('flags'))->map(fn ($number) => (int) $number)->unique()->values()->all();
    }

    /**
     * The client-reported start time, clamped so it can't be in the future.
     */
    public function startedAt(): Carbon
    {
        $startedAt = Carbon::createFromTimestampMs($this->validated('started_at'));

        return $startedAt->isFuture() ? now() : $startedAt;
    }
}
