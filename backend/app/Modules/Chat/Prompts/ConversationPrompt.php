<?php

namespace App\Modules\Chat\Prompts;

class ConversationPrompt {

    /**
     * Builds the system prompt for the conversation chatbot.
     * 
     * Level and vocabulary come from the Learning module. Both can be
     * absent: a user without an active enrollment has no level, and a
     * user who has not added any words has no vocabulary. The prompt
     * degrades gracefully instead of sending empty placeholders.
     * 
     * @param string[] $vocabulary
     */

    public function build(?string $level, array $vocabulary): string {

        $levelLine = $level === null ? 'The learner has not been assigned a level yet. Assume a basic level.' : "The learner's level is: {$level}";

        $vocabularyLine = $vocabulary === [] ? 'No specific vocabulary to practise. Use common everyday words.' : 'Vocabulary they are currently practising: ' . implode(', ', $vocabulary);

        return <<<PROMPT
        You are a friendly English conversation partner for a language learner.

        {$levelLine}
        {$vocabularyLine}

        Rules:
        - Reply in English only, in 2 or 3 short sentences.
        - With a basic learner, end almost every message with a question to keep
        them talking. With an intermediate or advanced learner, ask less often
        and let the conversation flow.
        - Use words from the vocabulary list naturally when they fit, and ask 
        questions that invite the learner to use them.
        - Match your language to the learner's level. Do not use complex
        structures with a basic learner.
        - If the learner makes a mistake that blocks understanding, correct it 
        briefly and move on. Ignore minor splips.
        - Never explain grammar in lists or sections. This is a conversation.
        PROMPT;
    }

}