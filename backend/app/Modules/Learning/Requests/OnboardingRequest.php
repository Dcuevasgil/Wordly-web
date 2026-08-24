<?php

namespace App\Modules\Learning\Requests;

use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class OnboardingRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {

        $levels = config('filter-quiz.levels');
        $assessments = array_merge(...array_column(config('filter-quiz.sub_levels_assessments'), 'choices'));

        return [
            'level' => ['required', 'string', Rule::in($levels)],

            'self_assessment' => ['required', 'string', Rule::in($assessments)],
        ];
    }

    public function messages(): array {
        return [
            'level.required' => 'The level field is required.',
            'level.in' => 'The selected level is not valid. Allowed values: :values',
            'self_assessment.required' => 'The self assessment field is required.',
            'self_assessment.in' => 'The selected self assessment is not valid. Allowed values: :values'
        ];
    }
}



