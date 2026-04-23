<?php

namespace Tests\Feature\Home;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowHomeTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders_redesigned_left_profile_panel(): void
    {
        $topic = Topic::factory()
            ->for(User::factory())
            ->create([
                'title' => 'Homepage Story',
                'excerpt' => 'A concise summary for homepage readers.',
                'is_published' => true,
            ]);

        $response = $this->get(route('home.show'));

        $response->assertOk();
        $response->assertSee('data-home-profile-panel', false);
        $response->assertSee(__('home.profile.title'));
        $response->assertSee(__('home.profile.description'));
        $response->assertSee(__('home.about.title'));
        $response->assertSee(__('home.tech_stack.title'));
        $response->assertSee('data-home-profile-actions', false);
        $response->assertSee('data-home-tech-stack', false);
        $response->assertSee(route('feeds.main'), false);
        $response->assertSee('https://github.com/Nza6920', false);
        $response->assertSee('class="home-theme-toggle"', false);
        $response->assertSee(__('home.search.placeholder'));
        $response->assertSee($topic->title);
    }

    public function test_home_page_keeps_search_and_pagination_available(): void
    {
        Topic::factory()
            ->count(11)
            ->for(User::factory())
            ->sequence(
                fn ($sequence) => [
                    'title' => 'Searchable Topic '.$sequence->index,
                    'excerpt' => 'Excerpt '.$sequence->index,
                    'is_published' => true,
                ]
            )
            ->create();

        $response = $this->get(route('home.show', [
            'keyword' => 'Searchable',
        ]));

        $response->assertOk();
        $response->assertSee('value="Searchable"', false);
        $response->assertSee('?keyword=Searchable&amp;page=2', false);
        $response->assertSee('class="home-theme-toggle"', false);
        $response->assertSee('class="js-search-toggle"', false);
    }

    public function test_home_page_uses_topic_cover_image_for_article_card(): void
    {
        $coverPath = 'http://localhost/uploads/images/covers/home-cover.jpg';

        Topic::factory()
            ->for(User::factory())
            ->create([
                'title' => 'Topic with custom cover',
                'cover_img' => $coverPath,
                'is_published' => true,
            ]);

        $response = $this->get(route('home.show'));

        $response->assertOk();
        $response->assertSee('src="'.$coverPath.'"', false);
    }

    public function test_home_page_uses_default_cover_when_topic_cover_is_missing(): void
    {
        Topic::factory()
            ->for(User::factory())
            ->create([
                'title' => 'Topic without custom cover',
                'cover_img' => null,
                'is_published' => true,
            ]);

        $response = $this->get(route('home.show'));

        $response->assertOk();
        $response->assertSee('uploads/images/system/default.jpg', false);
    }
}
