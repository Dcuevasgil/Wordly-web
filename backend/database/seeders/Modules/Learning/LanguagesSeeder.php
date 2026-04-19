<?php

namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesSeeder extends Seeder {
    public function run() {
        DB::table('languages')->insert([
            [
                'name' => 'English',
                'code' => 'en'
            ],
            [
                'name' => 'Spanish',
                'code' => 'es'
            ]
        ]);
    }
}