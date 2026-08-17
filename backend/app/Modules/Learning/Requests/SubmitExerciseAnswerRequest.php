<?php

namespace App\Modules\Learning\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitExerciseAnswerRequest extends FormRequest {

    public function authorize(): bool {
        return true;
    }

    public function rules(): array {

        return [
            'exercise_id' => ['required', 'integer', 'exists:exercises,id_exercises'],

            'user_responses' => ['present', 'array'],
            'user_responses.*' => ['required', 'string', 'max:255'],

            'exercise_answer_id' => [ 'nullable', 'integer', 'exists:exercise_answers,id_exercise_answers'],

            'response_time_ms' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array {
        return [
            'user_responses.present' => 'The user_responses field must be present.',
            'exercise_id.exists' => 'The specified exercise does not exist.'
        ];
    }
}



