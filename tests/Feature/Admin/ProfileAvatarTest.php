<?php

namespace Tests\Feature\Admin;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class ProfileAvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array<int, string>
     */
    private array $temporaryFiles = [];

    protected function tearDown(): void
    {
        foreach ($this->temporaryFiles as $path) {
            if (is_file($path)) {
                unlink($path);
            }
        }

        parent::tearDown();
    }

    public function test_admin_profile_avatar_updates_home_avatar_setting(): void
    {
        $user = User::factory()->create([
            'name' => 'Current Name',
            'email' => 'current@example.com',
            'avatar' => 'http://localhost/uploads/images/avatars/old-avatar.jpg',
        ]);
        $avatarPath = 'http://localhost/uploads/images/avatars/new-avatar.jpg';

        $this->mock(ImageUploadHandler::class, function (MockInterface $mock) use ($avatarPath) {
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(['path' => $avatarPath]);
        });

        $response = $this->actingAs($user)->post(route('admin.profile.update'), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'avatar' => $this->fakePngUpload('avatar.png', 100),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'avatar' => $avatarPath,
        ]);
        $this->assertDatabaseHas('portal_settings', [
            'home_avatar' => $avatarPath,
        ]);
    }

    private function fakePngUpload(string $name, int $kilobytes): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'profile-avatar-');
        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==',
            true
        );
        $targetBytes = $kilobytes * 1024;

        file_put_contents($path, $png.str_repeat('0', max(0, $targetBytes - strlen($png))));

        $this->temporaryFiles[] = $path;

        return new UploadedFile($path, $name, 'image/png', null, true);
    }
}
