<?php

namespace Database\Seeders\Modules\Learning;

use Illuminate\Database\Seeder;

// Modelos
use App\Modules\Learning\Models\LearningPath;

class LearningPathSeeder extends Seeder {

    public function run()
    {

        LearningPath::updateOrCreate(
            ['code' => 'general'],
            [
                'name' => 'General',
                'description' => 'Vocabulario general de inglés'
            ]
        );
    }
}