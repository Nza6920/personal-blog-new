<?php

namespace Tests\Feature\Topics;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTopicTest extends TestCase
{
    use RefreshDatabase;

    public function test_topic_detail_page_renders_table_of_contents_for_level_one_headings(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'body' => <<<'MARKDOWN'
# Overview

First section.

## Details

Second level section.

# Deep Dive

Second section.
MARKDOWN,
                'body_type' => 'MARKDOWN',
                'is_published' => true,
            ]);

        $response = $this->get(route('topics.show', $topic));

        $response->assertOk();
        $response->assertSee('<aside class="topic-toc" data-topic-toc', false);
        $response->assertSee('href="#overview"', false);
        $response->assertSee('href="#details"', false);
        $response->assertSee('href="#deep-dive"', false);
        $response->assertSee('topic-toc-item-level-2', false);
        $response->assertSee('<h1 id="overview" data-topic-section="overview">Overview</h1>', false);
        $response->assertSee('<h2 id="details" data-topic-section="details">Details</h2>', false);
        $response->assertSee('<h1 id="deep-dive" data-topic-section="deep-dive">Deep Dive</h1>', false);
    }

    public function test_markdown_tables_are_rendered_on_topic_detail_page(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'body' => <<<'MARKDOWN'
| 维度 | OpenSpec | Spec Kit |
|---|---|---|
| 核心思路 | 给 AI 开发加轻量 spec 护栏 | 把 SDD 做成完整工程流程 |
MARKDOWN,
                'body_type' => 'MARKDOWN',
                'is_published' => true,
            ]);

        $response = $this->get(route('topics.show', $topic));

        $response->assertOk();
        $response->assertSee('<table>', false);
        $response->assertSee('<th>OpenSpec</th>', false);
        $response->assertSee('<td>把 SDD 做成完整工程流程</td>', false);
    }

    public function test_topic_detail_page_renders_table_of_contents_for_second_level_headings(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'body' => <<<'MARKDOWN'
## Overview

Only a second-level heading exists here.

Plain paragraph content.
MARKDOWN,
                'body_type' => 'MARKDOWN',
                'is_published' => true,
            ]);

        $response = $this->get(route('topics.show', $topic));

        $response->assertOk();
        $response->assertSee('<aside class="topic-toc" data-topic-toc', false);
        $response->assertSee('href="#overview"', false);
        $response->assertSee('<h2 id="overview" data-topic-section="overview">Overview</h2>', false);
    }

    public function test_topic_detail_page_hides_table_of_contents_when_no_supported_heading_exists(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'body' => <<<'MARKDOWN'
### Overview

Only a third-level heading exists here.
MARKDOWN,
                'body_type' => 'MARKDOWN',
                'is_published' => true,
            ]);

        $response = $this->get(route('topics.show', $topic));

        $response->assertOk();
        $response->assertDontSee('<aside class="topic-toc" data-topic-toc', false);
    }

    public function test_topic_detail_page_assigns_unique_anchor_ids_to_duplicate_level_one_headings(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'body' => <<<'MARKDOWN'
# Overview

First section.

# Overview

Second section.
MARKDOWN,
                'body_type' => 'MARKDOWN',
                'is_published' => true,
            ]);

        $response = $this->get(route('topics.show', $topic));

        $response->assertOk();
        $response->assertSeeInOrder([
            'href="#overview"',
            'href="#overview-2"',
        ], false);
        $response->assertSee('<h1 id="overview" data-topic-section="overview">Overview</h1>', false);
        $response->assertSee('<h1 id="overview-2" data-topic-section="overview-2">Overview</h1>', false);
    }
}
