<?php

namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;

// Modelos
use App\Modules\Learning\Models\Exercise;
use App\Modules\Learning\Models\ExerciseAnswer;

class ExerciseSeeder extends Seeder {

    public function run()
    {

        // Limpiar antes de re-sembrar
        ExerciseAnswer::query()->delete();
        Exercise::query()->delete();

        // Array de ejercicios
        $exercises = [
            [
                'question' => '¿Cuál es el plural de "cat"?',
                'explanation' => 'El plural en inglés se forma añadiendo -s.',
                'topic_exercise' => 'plurals',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ["answer" => "cats", "is_correct_answer" => true],
                    ["answer" => "cates", "is_correct_answer" => false],
                    ["answer" => "cat's", "is_correct_answer" => false],
                    ["answer" => "cat", "is_correct_answer" => false],
                ]
            ],
            [
                'question' => '¿Cuál es el pasado simple de "go"?',
                'explanation' => '"go" es un verbo irregular, su pasado es "went".',
                'topic_exercise' => 'past-simple',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'went', 'is_correct_answer' => true],
                    ['answer' => 'goed', 'is_correct_answer' => false],
                    ['answer' => 'gone', 'is_correct_answer' => false],
                    ['answer' => 'going', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => '¿Qué significa "umbrella"?',
                'explanation' => '"Umbrella" significa paraguas en español.',
                'topic_exercise' => 'vocabulary-basics',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'Paraguas', 'is_correct_answer' => true],
                    ['answer' => 'Impermeable', 'is_correct_answer' => false],
                    ['answer' => 'Sombra', 'is_correct_answer' => false],
                    ['answer' => 'Bufanda', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => 'Elige la forma correcta: "She ___ to school every day."',
                'explanation' => 'Con tercera persona del singular en presente simple se añade -s al verbo.',
                'topic_exercise' => 'present-simple',
                'type_exercise' => 'fill-blank',
                'answers' => [
                    ['answer' => 'goes', 'is_correct_answer' => true],
                    ['answer' => 'go', 'is_correct_answer' => false],
                    ['answer' => 'going', 'is_correct_answer' => false],
                    ['answer' => 'gone', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => '¿Cuál es el opuesto de "hot"?',
                'explanation' => 'El opuesto de "hot" (caliente) es "cold" (frío).',
                'topic_exercise' => 'opposites',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'cold', 'is_correct_answer' => true],
                    ['answer' => 'warm', 'is_correct_answer' => false],
                    ['answer' => 'boiling', 'is_correct_answer' => false],
                    ['answer' => 'spicy', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => '¿Cuál es el pasado simple de "eat"?',
                'explanation' => '"eat" es irregular, su pasado es "ate".',
                'topic_exercise' => 'past-simple',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'ate', 'is_correct_answer' => true],
                    ['answer' => 'eated', 'is_correct_answer' => false],
                    ['answer' => 'eaten', 'is_correct_answer' => false],
                    ['answer' => 'eat', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => '¿Qué significa "butterfly"?',
                'explanation' => '"Butterfly" significa mariposa en español.',
                'topic_exercise' => 'vocabulary-basics',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'Mariposa', 'is_correct_answer' => true],
                    ['answer' => 'Polilla', 'is_correct_answer' => false],
                    ['answer' => 'Libélula', 'is_correct_answer' => false],
                    ['answer' => 'Mosca', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => 'Elige la forma correcta: "They ___ watching TV now."',
                'explanation' => 'Con "they" en presente continuo se usa "are".',
                'topic_exercise' => 'present-continuous',
                'type_exercise' => 'fill-blank',
                'answers' => [
                    ['answer' => 'are', 'is_correct_answer' => true],
                    ['answer' => 'is', 'is_correct_answer' => false],
                    ['answer' => 'were', 'is_correct_answer' => false],
                    ['answer' => 'be', 'is_correct_answer' => false],
                ]
            ],
            [
                'question' => '¿Cuál es el plural de "child"?',
                'explanation' => '"child" es irregular, su plural es "children".',
                'topic_exercise' => 'plurals',
                'type_exercise' => 'single-choice',
                'answers' => [
                    ['answer' => 'children', 'is_correct_answer' => true],
                    ['answer' => 'childs', 'is_correct_answer' => false],
                    ['answer' => 'childrens', 'is_correct_answer' => false],
                    ['answer' => 'child', 'is_correct_answer' => false],
                ]
            ],
        ];

        foreach ($exercises as $item) {

            $exercise = Exercise::create([
                'question' => $item['question'],
                'explanation' => $item['explanation'],
                'topic_exercise' => $item['topic_exercise'],
                'type_exercise' => $item['type_exercise'],
            ]);

            $answers = array_map(function ($answer) use ($item) {
                return [
                    'answer' => $answer['answer'],
                    'is_correct_answer' => $answer['is_correct_answer'],
                    'explanation' => $item['explanation']
                ];
            }, $item['answers']);

            $exercise->answers()->createMany($answers);
        }
    }
}