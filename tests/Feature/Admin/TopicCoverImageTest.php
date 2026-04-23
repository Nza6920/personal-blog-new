<?php

namespace Tests\Feature\Admin;

use App\Handlers\ImageUploadHandler;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Mockery\MockInterface;
use Tests\TestCase;

class TopicCoverImageTest extends TestCase
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

    public function test_admin_can_create_topic_with_cover_image(): void
    {
        $user = User::factory()->create();
        $coverPath = 'http://localhost/uploads/images/covers/create-cover.jpg';

        $this->mock(ImageUploadHandler::class, function (MockInterface $mock) use ($coverPath) {
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(['path' => $coverPath]);
        });

        $response = $this->actingAs($user)->post(route('admin.store'), [
            'title' => 'Topic with cover',
            'body' => 'Article body content.',
            'body_type' => 'MARKDOWN',
            'cover_img' => $this->fakePngUpload('cover.png', 100),
        ]);

        $response->assertRedirect(route('admin.show'));

        $this->assertDatabaseHas('topics', [
            'title' => 'Topic with cover',
            'cover_img' => $coverPath,
        ]);
    }

    public function test_admin_cannot_upload_cover_image_larger_than_500kb(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('admin.create'))
            ->post(route('admin.store'), [
                'title' => 'Oversized cover',
                'body' => 'Article body content.',
                'body_type' => 'MARKDOWN',
                'cover_img' => $this->fakePngUpload('cover.png', 501),
            ]);

        $response->assertRedirect(route('admin.create'));
        $response->assertSessionHasErrors('cover_img');
        $this->assertSame('封面图片不能超过 500KB。', session('errors')->first('cover_img'));

        $this->assertDatabaseMissing('topics', [
            'title' => 'Oversized cover',
        ]);
    }

    public function test_admin_can_update_topic_cover_image(): void
    {
        $user = User::factory()->create();
        $topic = Topic::factory()->for($user)->create([
            'cover_img' => 'http://localhost/uploads/images/covers/old-cover.jpg',
        ]);
        $coverPath = 'http://localhost/uploads/images/covers/update-cover.jpg';

        $this->mock(ImageUploadHandler::class, function (MockInterface $mock) use ($coverPath) {
            $mock->shouldReceive('save')
                ->once()
                ->andReturn(['path' => $coverPath]);
        });

        $response = $this->actingAs($user)->put(route('admin.topics.update', $topic), [
            'title' => 'Updated topic cover',
            'body' => 'Updated article body content.',
            'body_type' => 'HTML',
            'cover_img' => $this->fakePngUpload('new-cover.png', 100),
        ]);

        $response->assertRedirect(route('admin.show'));

        $this->assertDatabaseHas('topics', [
            'id' => $topic->id,
            'title' => 'Updated topic cover',
            'cover_img' => $coverPath,
        ]);
    }

    private function fakePngUpload(string $name, int $kilobytes): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'topic-cover-');
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
