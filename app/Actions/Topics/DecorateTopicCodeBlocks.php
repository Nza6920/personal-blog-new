<?php

namespace App\Actions\Topics;

use DOMDocument;
use DOMElement;
use DOMNode;

class DecorateTopicCodeBlocks
{
    public function handle(DOMDocument $document, DOMElement $container): void
    {
        $codeBlockIndex = 0;

        foreach ($this->collectCodeBlocks($container) as $codeBlock) {
            $codeBlockIndex++;

            if ($this->hasCopyButton($codeBlock)) {
                continue;
            }

            $codeBlock->setAttribute('data-copy-code-block', (string) $codeBlockIndex);

            $button = $document->createElement('button');
            $button->setAttribute('type', 'button');
            $button->setAttribute('class', 'topic-copy-button');
            $button->setAttribute('aria-label', __('topic.copy_code_aria_label'));
            $button->setAttribute('data-copy-button', '');
            $button->setAttribute('title', __('topic.copy_code'));

            $icon = $document->createElement('i');
            $icon->setAttribute('class', 'icon-clipboard');
            $icon->setAttribute('aria-hidden', 'true');

            $button->appendChild($icon);
            $codeBlock->insertBefore($button, $codeBlock->firstChild);
        }
    }

    private function collectCodeBlocks(DOMElement $container): array
    {
        $codeBlocks = [];

        foreach ($container->childNodes as $childNode) {
            $this->appendCodeBlockNodes($childNode, $codeBlocks);
        }

        return $codeBlocks;
    }

    private function appendCodeBlockNodes(DOMNode $node, array &$codeBlocks): void
    {
        if (! $node instanceof DOMElement) {
            return;
        }

        if (strtolower($node->tagName) === 'pre') {
            $codeBlocks[] = $node;
        }

        foreach ($node->childNodes as $childNode) {
            $this->appendCodeBlockNodes($childNode, $codeBlocks);
        }
    }

    private function hasCopyButton(DOMElement $codeBlock): bool
    {
        foreach ($codeBlock->childNodes as $childNode) {
            if (! $childNode instanceof DOMElement) {
                continue;
            }

            if (
                strtolower($childNode->tagName) === 'button'
                && $childNode->hasAttribute('data-copy-button')
            ) {
                return true;
            }
        }

        return false;
    }
}
