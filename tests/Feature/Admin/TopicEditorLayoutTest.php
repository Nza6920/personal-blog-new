<?php

namespace Tests\Feature\Admin;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TopicEditorLayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_page_uses_the_wider_responsive_editor_card(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.create'));

        $response->assertOk();
        $this->assertWiderEditorCard($response->getContent());
    }

    public function test_edit_page_uses_the_wider_responsive_editor_card(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->for($user)->create();

        $response = $this->actingAs($user)->get(route('admin.topics.edit', $topic));

        $response->assertOk();
        $this->assertWiderEditorCard($response->getContent());
    }

    private function assertWiderEditorCard(string $content): void
    {
        $this->assertStringContainsString(
            'class="mx-auto w-full max-w-5xl mt-3"',
            $content
        );
        $this->assertStringNotContainsString('max-w-3xl', $content);
    }
}
