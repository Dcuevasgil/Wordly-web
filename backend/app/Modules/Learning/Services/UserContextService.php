<?php

namespace App\Modules\Learning\Services;

use App\Modules\Learning\Models\UserPath;
use Illuminate\Support\Facades\DB;

class UserContextService {

    /**
     * Returns the level of the user's most recently accessed active enrollment
     * or null when the user has no active enrollment.
     */
    public function getCurrentLevel(int $userId): ?string {

        $userPath = UserPath::where('user_id', $userId)
            ->where('is_active', true)
            ->orderByDesc('last_access_date')
            ->first();

        return $userPath?->level;
    }

    /**
     * Returns a random sample of the user's vocabulary as plan string
     * 
     * Words due for review are preferred. When none are due, any of the
     * user's words are returned instead, so the caller always gets 
     * vocabulary as long as the user has any.
     * 
     * @return string[]
     */
    public function getVocabularySample(int $userId, int $limit): array {
        
        $dueWords = $this->queryUserWords($userId)
            ->where(function ($query) {
                $query->where('user_words.next_review', '<=', now())
                    ->orWhereNull('user_words.next_review');
            })
            ->inRandomOrder()
            ->limit($limit)
            ->pluck('words.text')
            ->all();
        
        if ($dueWords !== []) {
            return $dueWords;
        }

        return $this->queryUserWords($userId)
            ->inRandomOrder()
            ->limit($limit)
            ->pluck('words.text')
            ->all();

    }

    private function queryUserWords(int $userId) {
        
        return DB::table('user_words')
            ->join('words', 'user_words.word_id', '=', 'words.id_words')
            ->where('user_words.user_id', $userId);

    }

}