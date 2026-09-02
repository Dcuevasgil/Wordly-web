<?php

namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;

// Modelos
use App\Modules\Learning\Models\Exercise;
use App\Modules\Learning\Models\ExerciseAnswer;

class ExerciseSeeder extends Seeder {

    public function run()
    {

        // Array de ejercicios
        $exercises = [
            [
                'code' => 'plurals-01',
                'question' => '¿Cuál es el plural de "cat"?',
                'explanation' => 'El plural en inglés se forma añadiendo -s.',
                'topic_exercise' => 'plurals',
                'type_exercise' => 'single-choice',
                'level' => 'basic',
                'answers' => [
                    ["answer" => "cats", "is_correct_answer" => true],
                    ["answer" => "cates", "is_correct_answer" => false],
                    ["answer" => "cat's", "is_correct_answer" => false],
                    ["answer" => "cat", "is_correct_answer" => false],
                ]
            ],
            [
                'code' => 'past-simple-01',
                'question' => '¿Cuál es el pasado simple de "go"?',
                'explanation' => '"go" es un verbo irregular, su pasado es "went".',
                'topic_exercise' => 'past-simple',
                'type_exercise' => 'single-choice',
                'level' => 'intermediate',
                'answers' => [
                    ['answer' => 'went', 'is_correct_answer' => true],
                    ['answer' => 'goed', 'is_correct_answer' => false],
                    ['answer' => 'gone', 'is_correct_answer' => false],
                    ['answer' => 'going', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'vocabulary-basics-01',
                'question' => '¿Qué significa "umbrella"?',
                'explanation' => '"Umbrella" significa paraguas en español.',
                'topic_exercise' => 'vocabulary-basics',
                'type_exercise' => 'single-choice',
                'level' => 'basic',
                'answers' => [
                    ['answer' => 'Paraguas', 'is_correct_answer' => true],
                    ['answer' => 'Impermeable', 'is_correct_answer' => false],
                    ['answer' => 'Sombra', 'is_correct_answer' => false],
                    ['answer' => 'Bufanda', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'present-simple-01',
                'question' => 'Elige la forma correcta: "She ___ to school every day."',
                'explanation' => 'Con tercera persona del singular en presente simple se añade -s al verbo.',
                'topic_exercise' => 'present-simple',
                'type_exercise' => 'fill-blank',
                'level' => 'basic',
                'answers' => [
                    ['answer' => 'goes', 'is_correct_answer' => true],
                    ['answer' => 'go', 'is_correct_answer' => false],
                    ['answer' => 'going', 'is_correct_answer' => false],
                    ['answer' => 'gone', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'opposites-01',
                'question' => '¿Cuál es el opuesto de "hot"?',
                'explanation' => 'El opuesto de "hot" (caliente) es "cold" (frío).',
                'topic_exercise' => 'opposites',
                'type_exercise' => 'single-choice',
                'level' => 'basic',
                'answers' => [
                    ['answer' => 'cold', 'is_correct_answer' => true],
                    ['answer' => 'warm', 'is_correct_answer' => false],
                    ['answer' => 'boiling', 'is_correct_answer' => false],
                    ['answer' => 'spicy', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'past-simple-02',
                'question' => '¿Cuál es el pasado simple de "eat"?',
                'explanation' => '"eat" es irregular, su pasado es "ate".',
                'topic_exercise' => 'past-simple',
                'type_exercise' => 'single-choice',
                'level' => 'intermediate',
                'answers' => [
                    ['answer' => 'ate', 'is_correct_answer' => true],
                    ['answer' => 'eated', 'is_correct_answer' => false],
                    ['answer' => 'eaten', 'is_correct_answer' => false],
                    ['answer' => 'eat', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'vocabulary-basics-02',
                'question' => '¿Qué significa "butterfly"?',
                'explanation' => '"Butterfly" significa mariposa en español.',
                'topic_exercise' => 'vocabulary-basics',
                'type_exercise' => 'single-choice',
                'level' => 'basic',
                'answers' => [
                    ['answer' => 'Mariposa', 'is_correct_answer' => true],
                    ['answer' => 'Polilla', 'is_correct_answer' => false],
                    ['answer' => 'Libélula', 'is_correct_answer' => false],
                    ['answer' => 'Mosca', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'present-continuous-01',
                'question' => 'Elige la forma correcta: "They ___ watching TV now."',
                'explanation' => 'Con "they" en presente continuo se usa "are".',
                'topic_exercise' => 'present-continuous',
                'type_exercise' => 'fill-blank',
                'level' => 'intermediate',
                'answers' => [
                    ['answer' => 'are', 'is_correct_answer' => true],
                    ['answer' => 'is', 'is_correct_answer' => false],
                    ['answer' => 'were', 'is_correct_answer' => false],
                    ['answer' => 'be', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'plurals-02',
                'question' => '¿Cuál es el plural de "child"?',
                'explanation' => '"child" es irregular, su plural es "children".',
                'topic_exercise' => 'plurals',
                'type_exercise' => 'single-choice',
                'level' => 'basic',
                'answers' => [
                    ['answer' => 'children', 'is_correct_answer' => true],
                    ['answer' => 'childs', 'is_correct_answer' => false],
                    ['answer' => 'childrens', 'is_correct_answer' => false],
                    ['answer' => 'child', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'present-perfect-01',
                'question' => 'Elige la forma correcta: "I ___ never been to Japan."',
                'explanation' => 'El present perfect se forma con have/has + participio. Con "I" se usa "have"',
                'topic_exercise' => 'present-perfect',
                'type_exercise' => 'single-choice',
                'level' => 'intermediate',
                'answers' => [
                    ['answer' => 'have', 'is_correct_answer' => true],
                    ['answer' => 'has', 'is_correct_answer' => false],
                    ['answer' => 'am', 'is_correct_answer' => false],
                    ['answer' => 'had', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'conditionals-01',
                'question' => 'Elige la forma correcta: "If I ___ more time, I would travel more."',
                'explanation' => 'El segundo condicional se usa past simple en la cláusula "if" y "would" en la principal.',
                'topic_exercise' => 'conditionals',
                'type_exercise' => 'single-choice',
                'level' => 'advanced',
                'answers' => [
                    ['answer' => 'had', 'is_correct_answer' => true],
                    ['answer' => 'have', 'is_correct_answer' => false],
                    ['answer' => 'would have', 'is_correct_answer' => false],
                    ['answer' => 'will have', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'passive-voice-01',
                'question' => 'Elige la forma correcta: "The letter ___ yesterday."',
                'explanation' => 'La pasiva en pasado se forma con was/were + participio. "Letter" es singular, así que "was"',
                'topic_exercise' => 'passive-voice',
                'type_exercise' => 'single-choice',
                'level' => 'advanced',
                'answers' => [
                    ['answer' => 'was sent', 'is_correct_answer' => true],
                    ['answer' => 'sent', 'is_correct_answer' => false],
                    ['answer' => 'were sent', 'is_correct_answer' => false],
                    ['answer' => 'is sent', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'reported-speech-01',
                'question' => 'Elige la forma correcta: "She said that she ___ tired."',
                'explanation' => 'En el estilo indirecto el presente "am/is" retrocede a pasado: "was".',
                'topic_exercise' => 'reported-speech',
                'type_exercise' => 'single-choice',
                'level' => 'advanced',
                'answers' => [
                    ['answer' => 'was', 'is_correct_answer' => true],
                    ['answer' => 'is', 'is_correct_answer' => false],
                    ['answer' => 'has been', 'is_correct_answer' => false],
                    ['answer' => 'were', 'is_correct_answer' => false],
                ]
            ],
            [
                'code' => 'relative-clauses-01',
                'question' => 'Elige la forma correcta: "The woman ___ lives next door is a doctor."',
                'explanation' => 'Para personas se usa "who". "Which" es para cosas y "whose" indica posesión.',
                'topic_exercise' => 'relative-clauses',
                'type_exercise' => 'single-choice',
                'level' => 'advanced',
                'answers' => [
                    ['answer' => 'who', 'is_correct_answer' => true],
                    ['answer' => 'which', 'is_correct_answer' => false],
                    ['answer' => 'whose', 'is_correct_answer' => false],
                    ['answer' => 'what', 'is_correct_answer' => false],
                ]
            ],
        ];

        foreach ($exercises as $item) {

            $exercise = Exercise::updateOrCreate(
                ['code' => $item['code']],
                [
                    'question' => $item['question'],
                    'explanation' => $item['explanation'],
                    'topic_exercise' => $item['topic_exercise'],
                    'type_exercise' => $item['type_exercise'],
                    'level' => $item['level'],
                ]
            );

            foreach ($item['answers'] as $answer) {
                $exercise->answers()->updateOrCreate(
                    ['answer' => $answer['answer']],
                    [
                        'is_correct_answer' => $answer['is_correct_answer'],
                        'explanation' => $item['explanation'],
                    ]
                );
            }

        }
    }
}