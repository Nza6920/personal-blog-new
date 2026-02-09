<?php

namespace Tests\Feature\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Tests\TestCase;

class FortifyAuthenticationTest extends TestCase
{
    public function test_guest_is_redirected_from_admin_entry_to_login(): void
    {
        $response = $this->get('/admin');

        $response->assertRedirect(route('login'));
    }

    public function test_login_page_uses_existing_sessions_login_view(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertViewIs('sessions.login');
    }

    public function test_login_requires_email_and_password_fields(): void
    {
        $response = $this->from(route('login'))->post(route('login.store'), []);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_authenticated_user_can_logout_through_fortify_route(): void
    {
        $user = new class implements Authenticatable
        {
            public function getAuthIdentifierName(): string
            {
                return 'id';
            }

            public function getAuthIdentifier(): int
            {
                return 1;
            }

            public function getAuthPasswordName(): string
            {
                return 'password';
            }

            public function getAuthPassword(): string
            {
                return 'secret';
            }

            public function getRememberToken(): ?string
            {
                return null;
            }

            public function setRememberToken($_value): void
            {
            }

            public function getRememberTokenName(): string
            {
                return 'remember_token';
            }
        };

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
