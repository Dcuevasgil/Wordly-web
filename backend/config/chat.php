<?php

return [

    /* 
    |-----------------------------------------------------
    | Conversation title
    |-----------------------------------------------------
    | Max length of the auto-generated title, derived from the first user message. 
    | The DB column allows 150 chars; this is the display limit.
    */
    'title_max_length' => 60,

    /* 
    |--------------------------------------------------------------------------
    | Message content
    |--------------------------------------------------------------------------
    */
    'message_max_length' => 2000,


    /* 
    |-----------------------------------------------------
    | Ollama
    |-----------------------------------------------------
    | Token ceiling the model keeps in memory per request.
    | Verified ceiling is 16384; 8192 leaves more VRAM headroom.
    */
    'ollama' => [
        'base_url' => env('OLLAMA_BASE_URL', 'http://localhost:11434'),
        'model' => env('OLLAMA_MODEL', 'qwen2.5:7b'),
        'timeout' => (int) env('OLLAMA_TIMEOUT', 120),
        'num_ctx' => 8192,
    ],

    /* 
    |-----------------------------------------------------
    | History window
    |-----------------------------------------------------
    | How many past messages are sent to the model, counting user and assistant turns. 
    | Application-level cap, independent of num_ctx.
    */
    'history_window' => 10,

    /* 
    |-----------------------------------------------------
    | Vocabulary window
    |-----------------------------------------------------
    | How many of the user's words are sent to the model as suggested 
    | vocabulary. Words due for review are preferred; if none are due,
    | any of the user's words are used instead.
    */
    'vocabulary_window' => 20,

];