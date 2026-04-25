<?php

namespace Tests\Feature\Admin;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicEstimatedReadTimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_create_calculates_estimated_read_time_from_markdown_plain_text(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.store'), [
            'title' => 'Markdown read time topic',
            'body' => $this->markdownBodyWithWords(240),
            'body_type' => 'MARKDOWN',
        ]);

        $response->assertRedirect(route('admin.show'));

        $this->assertDatabaseHas('topics', [
            'title' => 'Markdown read time topic',
            'estimated_read_time' => 2,
        ]);
    }

    public function test_admin_update_recalculates_estimated_read_time_from_html_plain_text(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->for($user)->create([
            'body' => '<p>Short body.</p>',
            'body_type' => 'HTML',
        ]);

        $response = $this->actingAs($user)->put(route('admin.topics.update', $topic), [
            'title' => $topic->title,
            'body' => $this->htmlBodyWithWords(420),
            'body_type' => 'HTML',
        ]);

        $response->assertRedirect(route('admin.show'));

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'estimated_read_time' => 3,
        ]);
    }

    private function markdownBodyWithWords(int $count): string
    {
        $words = implode(' ', array_fill(0, $count, 'reader'));

        return <<<MD
# Heading

This intro includes **bold** text, a [link](https://example.com), and some `inline code`.

> {$words}

- item one
- item two
MD;
    }

    private function htmlBodyWithWords(int $count): string
    {
        $words = implode(' ', array_fill(0, $count, 'article'));

        return <<<HTML
<h1>Title</h1>
<p><strong>Lead</strong> copy before the main body.</p>
<div><p>{$words}</p><code>ignored_function()</code></div>
HTML;
    }
}
