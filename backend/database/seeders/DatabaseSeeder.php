<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\Modules\Learning\LearningPathSeeder;
use Database\Seeders\Modules\Learning\LanguagesSeeder;
use Database\Seeders\Modules\Learning\WordsSeeder;
use Database\Seeders\Modules\Learning\ExerciseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            LearningPathSeeder::class,
            LanguagesSeeder::class,
            WordsSeeder::class,
            ExerciseSeeder::class,
            
        ]);
    }
}
