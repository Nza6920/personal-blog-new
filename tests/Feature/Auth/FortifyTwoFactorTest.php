<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class FortifyTwoFactorTest extends TestCase
{
    public function test_guest_is_redirected_when_accessing_two_factor_challenge(): void
    {
        $response = $this->get('/two-factor-challenge');

        $response->assertRedirect(route('login'));
    }

    public function test_profile_page_shows_enable_button_when_two_factor_is_disabled(): void
    {
        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'secret',
            'avatar' => 'https://example.com/avatar.png',
        ]);
        $user->id = 1;
        /** @var Authenticatable $user */

        $response = $this->actingAs($user)->get(route('admin.profile'));

        $response->assertOk();
        $response->assertSee(__('admin_ui.profile.two_factor.title'));
        $response->assertSee(__('admin_ui.profile.modals.enable_two_factor.trigger'));
    }

    public function test_profile_page_shows_recovery_codes_when_two_factor_is_enabled(): void
    {
        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'secret',
            'avatar' => 'https://example.com/avatar.png',
        ]);
        $user->forceFill([
            'two_factor_secret' => encrypt('JBSWY3DPEHPK3PXP'),
            'two_factor_recovery_codes' => encrypt(json_encode(['code-alpha', 'code-beta'], JSON_THROW_ON_ERROR)),
        ]);
        $user->id = 1;
        /** @var Authenticatable $user */

        $response = $this->actingAs($user)->get(route('admin.profile'));

        $response->assertOk();
        $response->assertSee(__('admin_ui.profile.modals.disable_two_factor.trigger'));
        $response->assertSee('code-alpha');
        $response->assertSee('code-beta');
    }
}
