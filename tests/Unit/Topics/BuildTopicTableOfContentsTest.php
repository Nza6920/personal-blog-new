<?php

namespace Tests\Unit\Topics;

use App\Actions\Topics\BuildTopicTableOfContents;
use App\Models\Topic;
use Tests\TestCase;

class BuildTopicTableOfContentsTest extends TestCase
{
    public function test_it_builds_table_of_contents_items_from_markdown_headings(): void
    {
        $topic = new Topic([
            'body' => <<<'MARKDOWN'
# Overview

Body content.

## Details

Extra detail.

# Deep Dive

More body content.
MARKDOWN,
            'body_type' => 'MARKDOWN',
        ]);

        $result = app(BuildTopicTableOfContents::class)->handle($topic);

        $this->assertSame([
            ['id' => 'overview', 'level' => 1, 'title' => 'Overview'],
            ['id' => 'details', 'level' => 2, 'title' => 'Details'],
            ['id' => 'deep-dive', 'level' => 1, 'title' => 'Deep Dive'],
        ], $result['items']);
        $this->assertStringContainsString('id="overview"', $result['bodyHtml']);
        $this->assertStringContainsString('id="details"', $result['bodyHtml']);
        $this->assertStringContainsString('id="deep-dive"', $result['bodyHtml']);
    }

    public function test_it_builds_table_of_contents_from_second_level_headings_when_no_level_one_heading_exists(): void
    {
        $topic = new Topic([
            'body' => <<<'MARKDOWN'
## Overview

Only second-level content.
MARKDOWN,
            'body_type' => 'MARKDOWN',
        ]);

        $result = app(BuildTopicTableOfContents::class)->handle($topic);

        $this->assertSame([
            ['id' => 'overview', 'level' => 2, 'title' => 'Overview'],
        ], $result['items']);
    }

    public function test_it_returns_no_items_when_no_supported_heading_exists(): void
    {
        $topic = new Topic([
            'body' => <<<'MARKDOWN'
### Overview

Only third-level content.
MARKDOWN,
            'body_type' => 'MARKDOWN',
        ]);

        $result = app(BuildTopicTableOfContents::class)->handle($topic);

        $this->assertSame([], $result['items']);
    }

    public function test_it_generates_unique_anchor_ids_for_duplicate_headings(): void
    {
        $topic = new Topic([
            'body' => <<<'HTML'
<h1>Overview</h1>
<p>First section.</p>
<h1>Overview</h1>
<p>Second section.</p>
HTML,
            'body_type' => 'HTML',
        ]);

        $result = app(BuildTopicTableOfContents::class)->handle($topic);

        $this->assertSame([
            ['id' => 'overview', 'level' => 1, 'title' => 'Overview'],
            ['id' => 'overview-2', 'level' => 1, 'title' => 'Overview'],
        ], $result['items']);
        $this->assertStringContainsString('id="overview"', $result['bodyHtml']);
        $this->assertStringContainsString('id="overview-2"', $result['bodyHtml']);
    }
}
