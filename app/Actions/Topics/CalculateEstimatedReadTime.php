<?php

namespace App\Actions\Topics;

use League\CommonMark\CommonMarkConverter;

class CalculateEstimatedReadTime
{
    private const WORDS_PER_MINUTE = 200;

    public function __construct(
        private readonly CommonMarkConverter $markdownConverter = new CommonMarkConverter
    ) {}

    public function handle(?string $body, ?string $bodyType = null): ?int
    {
        $body = trim((string) $body);

        if ($body === '') {
            return null;
        }

        $plainText = $this->toPlainText($body, $bodyType);

        if ($plainText === '') {
            return null;
        }

        preg_match_all('/\p{Han}|[\p{L}\p{N}]+(?:[\'’-][\p{L}\p{N}]+)*/u', $plainText, $matches);
        $tokenCount = count($matches[0]);

        if ($tokenCount === 0) {
            return null;
        }

        return max(1, (int) ceil($tokenCount / self::WORDS_PER_MINUTE));
    }

    private function toPlainText(string $body, ?string $bodyType): string
    {
        $normalizedBody = strtoupper((string) $bodyType) === 'MARKDOWN'
            ? (string) $this->markdownConverter->convert($body)
            : clean($body, 'user_topic_body');

        $plainText = trim(strip_tags($normalizedBody));

        $plainText = preg_replace('/&[a-zA-Z0-9#]+;/', ' ', html_entity_decode($plainText, ENT_QUOTES | ENT_HTML5, 'UTF-8'));
        $plainText = preg_replace('/\s+/u', ' ', (string) $plainText);

        return trim((string) $plainText);
    }
}
