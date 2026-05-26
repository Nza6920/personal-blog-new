<?php

namespace App\Actions\Topics;

use DOMElement;
use DOMNode;
use Illuminate\Support\Str;

class ExtractTopicTableOfContents
{
    public function handle(DOMElement $container): array
    {
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

        return $items;
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
}
