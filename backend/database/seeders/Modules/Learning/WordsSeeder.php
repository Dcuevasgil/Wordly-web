<?php


namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WordsSeeder extends Seeder {


    public function run(): void {

        $words = [
            [
                'text' => 'house', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'car', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'dog', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'cat', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'book', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'water', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'food', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'sun', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'moon', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'tree', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'run', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'walk', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'eat', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'drink', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'sleep', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'write', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'read', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'speak', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'listen', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
            [
                'text' => 'learn', 
                'origin_language_id' => 1, 
                'difficult' => 1
            ],
        ];

        DB::table('words')->insert($words);
    }

}
