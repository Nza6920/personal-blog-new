<?php

namespace App\Actions\Topics;

use App\Models\Topic;
use DOMDocument;
use DOMElement;
use DOMNode;
use Illuminate\Support\Str;

class BuildTopicTableOfContents
{
    public function handle(Topic $topic): array
    {
        $bodyHtml = $topic->body_type === 'MARKDOWN'
            ? render_markdown($topic->body)
            : (string) $topic->body;

        if ($bodyHtml === '') {
            return [
                'bodyHtml' => '',
                'items' => [],
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
                'items' => [],
            ];
        }

        $items = [];
        $usedIds = [];
        $headingIndex = 0;
        $headings = $this->collectHeadings($container);

        /** @var DOMElement $heading */
        foreach ($headings as $heading) {
            $headingIndex++;

            $title = trim(preg_replace('/\s+/u', ' ', $heading->textContent ?? '') ?? '');
            $currentId = trim($heading->getAttribute('id'));
            $baseId = $currentId !== ''
                ? $currentId
                : $this->makeBaseId($title, $headingIndex);
            $id = $this->makeUniqueId($baseId, $usedIds);

            $heading->setAttribute('id', $id);
            $heading->setAttribute('data-topic-section', $id);

            $items[] = [
                'id' => $id,
                'level' => (int) str_replace('h', '', strtolower($heading->tagName)),
                'title' => $title !== ''
                    ? $title
                    : __('topic.section_fallback', ['number' => $headingIndex]),
            ];
        }

        return [
            'bodyHtml' => $this->extractInnerHtml($container),
            'items' => $items,
        ];
    }

    private function makeBaseId(string $title, int $headingIndex): string
    {
        $slug = Str::slug($title);

        if ($slug !== '') {
            return $slug;
        }

        return 'section-'.$headingIndex;
    }

    private function makeUniqueId(string $baseId, array &$usedIds): string
    {
        $candidate = $baseId;
        $suffix = 2;

        while (in_array($candidate, $usedIds, true)) {
            $candidate = $baseId.'-'.$suffix;
            $suffix++;
        }

        $usedIds[] = $candidate;

        return $candidate;
    }

    private function extractInnerHtml(DOMElement $container): string
    {
        $html = '';

        foreach ($container->childNodes as $childNode) {
            $html .= $container->ownerDocument->saveHTML($childNode);
        }

        return $html;
    }

    private function collectHeadings(DOMElement $container): array
    {
        $headings = [];

        foreach ($container->childNodes as $childNode) {
            $this->appendHeadingNodes($childNode, $headings);
        }

        return $headings;
    }

    private function appendHeadingNodes(DOMNode $node, array &$headings): void
    {
        if (! $node instanceof DOMElement) {
            return;
        }

        if (in_array(strtolower($node->tagName), ['h1', 'h2'], true)) {
            $headings[] = $node;
        }

        foreach ($node->childNodes as $childNode) {
            $this->appendHeadingNodes($childNode, $headings);
        }
    }
}
