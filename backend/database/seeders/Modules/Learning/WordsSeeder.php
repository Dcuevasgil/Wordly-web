<?php


namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;
use App\Modules\Learning\Models\Language;
use App\Modules\Learning\Models\Word;

class WordsSeeder extends Seeder {


    public function run(): void {

        $originId = Language::where('code', 'en')->value('id_languages');
        $targetId = Language::where('code', 'es')->value('id_languages');

        if (!$originId || !$targetId) {
            throw new \RuntimeException('Languages "en" and "es" must be seeded first.');
        }

        $words = [
            [
                'text' => 'house', 
                'translation' => 'casa', 
                'example' => 'I live in a small house.'
            ],
            [
                'text' => 'car', 
                'translation' => 'coche', 
                'example' => 'My car is very old.'
            ],
            [
                'text' => 'dog', 
                'translation' => 'perro', 
                'example' => 'The dog is sleeping.'
            ],
            [
                'text' => 'cat', 
                'translation' => 'gato', 
                'example' => 'The cat is on the table.'
            ],
            [
                'text' => 'book', 
                'translation' => 'libro', 
                'example' => 'I read a book every week.'
            ],
            [
                'text' => 'water', 
                'translation' => 'agua', 
                'example' => 'I drink water every morning.'
            ],
            [
                'text' => 'food', 
                'translation' => 'comida', 
                'example' => 'The food is on the table.'
            ],
            [
                'text' => 'sun', 
                'translation' => 'sol', 
                'example' => 'The sun is very bright today.'
            ],
            [
                'text' => 'moon', 
                'translation' => 'luna', 
                'example' => 'The moon is full tonight.'
            ],
            [
                'text' => 'tree', 
                'translation' => 'árbol', 
                'example' => 'There is a tree in the garden.'
            ],
            [
                'text' => 'run', 
                'translation' => 'correr', 
                'example' => 'I run every morning.'
            ],
            [
                'text' => 'walk', 
                'translation' => 'caminar', 
                'example' => 'We walk to school together.'
            ],
            [
                'text' => 'eat', 
                'translation' => 'comer', 
                'example' => 'They eat dinner at eight.'
            ],
            [
                'text' => 'drink', 
                'translation' => 'beber', 
                'example' => 'She likes to drink tea.'
            ],
            [
                'text' => 'sleep', 
                'translation' => 'dormir', 
                'example' => 'I sleep eight hours a night.'
            ],
            [
                'text' => 'write', 
                'translation' => 'escribir', 
                'example' => 'He writes letters to his family.'
            ],
            [
                'text' => 'read', 
                'translation' => 'leer', 
                'example' => 'She reads before going to bed.'
            ],
            [
                'text' => 'speak', 
                'translation' => 'hablar', 
                'example' => 'I speak two languages.'
            ],
            [
                'text' => 'listen', 
                'translation' => 'escuchar', 
                'example' => 'They listen to music every day.'
            ],
            [
                'text' => 'learn', 
                'translation' => 'aprender', 
                'example' => 'We learn something new every day.'
            ],
        ];

        foreach ($words as $item) {
            
            $word = Word::updateOrCreate(
                [
                    'text' => $item['text'],
                    'origin_language_id' => $originId,
                ],
                [
                    'difficult' => 1,
                ]
            );

            $word->translations()->updateOrCreate(
                [
                    'target_language_id' => $targetId,
                ],
                [
                    'translation' => $item['translation'],
                    'example' => $item['example'],
                ]
            );
        }
    }

}
