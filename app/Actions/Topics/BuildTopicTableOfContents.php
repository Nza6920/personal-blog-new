<?php

namespace App\Actions\Topics;

use App\Models\Topic;
use DOMElement;

class BuildTopicTableOfContents
{
    public function __construct(
        private readonly DecorateTopicCodeBlocks $decorateTopicCodeBlocks,
        private readonly ExtractTopicTableOfContents $extractTopicTableOfContents,
        private readonly RenderTopicContent $renderTopicContent,
    ) {}

    public function handle(Topic $topic): array
    {
        $renderedContent = $this->renderTopicContent->handle($topic);
        $container = $renderedContent['container'];
        $document = $renderedContent['document'];

        if (! $container instanceof DOMElement || $document === null) {
            return [
                'bodyHtml' => $renderedContent['bodyHtml'],
                'items' => [],
            ];
        }

        $this->decorateTopicCodeBlocks->handle($document, $container);
        $items = $this->extractTopicTableOfContents->handle($container);

        return [
            'bodyHtml' => $this->renderTopicContent->extractInnerHtml($container),
            'items' => $items,
        ];
    }
}
