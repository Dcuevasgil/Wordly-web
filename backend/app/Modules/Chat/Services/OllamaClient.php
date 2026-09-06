<?php

namespace App\Modules\Chat\Services;

use Illuminate\Support\Facades\Http;
use RuntimeException;

class OllamaClient {

    /**
     * Sends a chat completion request to the local Ollama server.
     * 
     * Messages must follow Ollama's format: an ordered list of
     * ['role' => 'system'|'user'|'assistant, 'content' => string].
     * 
     * @param array<int, array{role: string, content: string}> $messages
     * @return array{content: string, model: string, tokens_used: ?int, latency_ms: ?int}
     */
    public function chat(array $messages): array {

        $config = config('chat.ollama');

        $response = Http::timeout($config['timeout'])
            ->post($config['base_url'] . '/api/chat', [
                'model' => $config['model'],
                'messages' => $messages,
                'stream' => false,
                'options' => [
                    'num_ctx' => $config['num_ctx'],
                ],
            ]);
        
        if ($response->failed()) {
            throw new RuntimeException(
                'Ollama request failed with status ' . $response->status()
            );
        }

        $content = $response->json('message.content');

        if (!is_string($content) || trim($content) === '') {
            throw new RuntimeException('Ollama returned an empty response');
        }

        return [
            'content' => trim($content),
            'model' => $config['model'],
            'tokens_used' => $response->json('eval_count'),
            'latency_ms' => $this->toMilliseconds($response->json('total_duration')),
        ];
    }


    /**
     * Ollama reports durations in nanoseconds.
     */
    private function toMilliseconds(?int $nanoseconds): ?int {

        return $nanoseconds === null ? null : (int) round($nanoseconds / 1_000_000);

    }

}