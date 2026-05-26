<?php

namespace App\Actions\Topics;

use App\Models\Topic;
use DOMDocument;
use DOMElement;

class RenderTopicContent
{
    public function handle(Topic $topic): array
    {
        $bodyHtml = $topic->body_type === 'MARKDOWN'
            ? render_markdown($topic->body)
            : (string) $topic->body;

        if ($bodyHtml === '') {
            return [
                'bodyHtml' => '',
                'container' => null,
                'document' => null,
            ];
        }

        $document = new DOMDocument('1.0', 'UTF-8');
        $wrappedHtml = '<?xml encoding="utf-8" ?><div id="topic-content-root">'.$bodyHtml.'</div>';

        libxml_use_internal_errors(true);
        $document->loadHTML($wrappedHtml, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();
        libxml_use_internal_errors(false);

        $container = $document->getElementById('topic-content-root');

        if (! $container instanceof DOMElement) {
            return [
                'bodyHtml' => $bodyHtml,
                'container' => null,
                'document' => null,
            ];
        }

        return [
            'bodyHtml' => $bodyHtml,
            'container' => $container,
            'document' => $document,
        ];
    }

    public function extractInnerHtml(DOMElement $container): string
    {
        $html = '';

        foreach ($container->childNodes as $childNode) {
            $html .= $container->ownerDocument->saveHTML($childNode);
        }

        return $html;
    }
}
