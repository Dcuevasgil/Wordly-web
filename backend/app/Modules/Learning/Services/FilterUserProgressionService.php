<?php

namespace App\Modules\Learning\Services;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Modules\Auth\Models\User;
use App\Modules\Learning\Models\Exercise;

class FilterUserProgressionService {


    private readonly array $levels;

    public function __construct(?array $levels = null) {
        $this->levels = $levels ?? config('filter-quiz.levels', []);
    }

    /**
     * Returns every level accessible to a user at the given level,
     * including the level itself (ceiling approach).
     * 'intermediate' => ['basic', 'intermediate']
     * 
     * Returns an empty array when the level is unknown or null, 
     * so the caller must decide what to do instead of silently querying everything
     * 
     */

    public function getAccessibleLevels(?string $userLevel): array {

        if ($userLevel === null) {
            return [];
        }

        $index = array_search($userLevel, $this->levels, true);

        if ($index === false) {
            return [];
        }

        return array_slice($this->levels, 0, $index + 1);

    }

}




