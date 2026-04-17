<?php

namespace Tests\Feature\Topics;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowTopicTest extends TestCase
{
    use RefreshDatabase;

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
}
