<?php

namespace Tests\Feature\Admin;

use App\Models\PortalSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeProfileContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_profile_page_renders_home_profile_defaults(): void
    {
        PortalSetting::query()->delete();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('admin.profile'));

        $response->assertOk();
        $response->assertSee(__('admin_ui.profile.home_profile.title'));
        $response->assertSee(__('admin_ui.profile.home_profile.title_label'));
        $response->assertSee(__('admin_ui.profile.home_profile.section_label'));
        $response->assertSee(__('admin_ui.profile.home_profile.tags_label'));
        $response->assertSee('data-home-profile-tags-editor', false);
        $response->assertSee(__('home.profile.title'));
        $response->assertSee(__('home.profile.description'));
        $response->assertSee(__('home.tech_stack.items')[0]);
    }

    public function test_admin_profile_page_renders_saved_home_profile_values(): void
    {
        $user = User::factory()->create();

        PortalSetting::query()->updateOrCreate([], [
            'home_profile_title' => 'Saved title',
            'home_profile_section' => 'Saved profile section',
            'home_profile_tags' => ['Laravel', 'Redis'],
        ]);

        $response = $this->actingAs($user)->get(route('admin.profile'));

        $response->assertOk();
        $response->assertSee('Saved title');
        $response->assertSee('Saved profile section');
        $response->assertSee('Laravel');
        $response->assertSee('Redis');
    }

    public function test_admin_can_save_home_profile_content(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('admin.profile.home-profile'), [
            'home_profile_title' => 'Configured title',
            'home_profile_section' => 'Configured section body',
            'home_profile_tags' => "Laravel\nRedis, Docker\nLaravel",
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', __('admin_ui.profile.home_profile.updated'));

        $setting = PortalSetting::query()->first();

        $this->assertSame('Configured title', $setting->home_profile_title);
        $this->assertSame('Configured section body', $setting->home_profile_section);
        $this->assertSame(['Laravel', 'Redis', 'Docker'], $setting->home_profile_tags);
    }

    public function test_invalid_home_profile_content_does_not_overwrite_saved_values(): void
    {
        $user = User::factory()->create();

        PortalSetting::query()->updateOrCreate([], [
            'home_profile_title' => 'Original title',
            'home_profile_section' => 'Original section',
            'home_profile_tags' => ['Original'],
        ]);

        $response = $this->actingAs($user)
            ->from(route('admin.profile'))
            ->post(route('admin.profile.home-profile'), [
                'home_profile_title' => '',
                'home_profile_section' => 'Updated section',
                'home_profile_tags' => 'Updated',
            ]);

        $response->assertRedirect(route('admin.profile'));
        $response->assertSessionHasErrors('home_profile_title');

        $setting = PortalSetting::query()->first();

        $this->assertSame('Original title', $setting->home_profile_title);
        $this->assertSame('Original section', $setting->home_profile_section);
        $this->assertSame(['Original'], $setting->home_profile_tags);
    }
}
