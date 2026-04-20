<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\Modules\Learning\WordsSeeder;
use Database\Seeders\Modules\Learning\LanguagesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            LanguagesSeeder::class,
            WordsSeeder::class
        );
    }
}
