<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper to create a valid fake image with real binary headers (without requiring GD).
     */
    protected function createFakeImage(string $filename = 'test.jpg'): UploadedFile
    {
        // 1x1 transparent GIF binary data
        $content = base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

        return UploadedFile::fake()->createWithContent($filename, $content);
    }

    public function test_post_listing_displays_posts_and_stats(): void
    {
        Post::factory()->create(['title' => 'First Post', 'status' => 'Active']);
        Post::factory()->create(['title' => 'Second Post', 'status' => 'Inactive']);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('First Post');
        $response->assertSee('Second Post');
        $response->assertSee('Post Management');
    }

    public function test_can_search_posts_by_title(): void
    {
        Post::factory()->create(['title' => 'Unique Exploring Safari']);
        Post::factory()->create(['title' => 'Skiing in Switzerland']);

        $response = $this->get(route('posts.index', ['search' => 'Safari']));

        $response->assertStatus(200);
        $response->assertSee('Unique Exploring Safari');
        $response->assertDontSee('Skiing in Switzerland');
    }

    public function test_can_filter_posts_by_status(): void
    {
        Post::factory()->create(['title' => 'Active Adventure', 'status' => 'Active']);
        Post::factory()->create(['title' => 'Draft Adventure', 'status' => 'Inactive']);

        $response = $this->get(route('posts.index', ['status' => 'Active']));

        $response->assertStatus(200);
        $response->assertSee('Active Adventure');
        $response->assertDontSee('Draft Adventure');
    }

    public function test_can_create_new_post_with_image_upload(): void
    {
        Storage::fake('public');

        $file = $this->createFakeImage('scenery.jpg');

        $response = $this->post(route('posts.store'), [
            'title' => 'My New Test Post',
            'description' => 'This is a test post description for vacation.',
            'image' => $file,
            'status' => 'Active',
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'title' => 'My New Test Post',
            'status' => 'Active',
        ]);

        $post = Post::where('title', 'My New Test Post')->first();
        Storage::disk('public')->assertExists($post->image);
    }

    public function test_create_post_validation_fails_when_fields_missing(): void
    {
        $response = $this->post(route('posts.store'), []);

        $response->assertSessionHasErrors(['title', 'description', 'image', 'status']);
    }

    public function test_can_view_post_details(): void
    {
        $post = Post::factory()->create([
            'title' => 'Detail View Test Post',
            'description' => 'Detailed text goes here.',
            'status' => 'Active',
        ]);

        $response = $this->get(route('posts.show', $post));

        $response->assertStatus(200);
        $response->assertSee('Detail View Test Post');
        $response->assertSee('Detailed text goes here.');
    }

    public function test_can_update_post_without_changing_image(): void
    {
        $post = Post::factory()->create([
            'title' => 'Old Post Title',
            'description' => 'Old description',
            'image' => 'posts/sample.jpg',
            'status' => 'Active',
        ]);

        $response = $this->put(route('posts.update', $post), [
            'title' => 'Updated Post Title',
            'description' => 'Updated description content',
            'status' => 'Inactive',
        ]);

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'image' => 'posts/sample.jpg',
            'status' => 'Inactive',
        ]);
    }

    public function test_can_delete_post(): void
    {
        Storage::fake('public');
        $post = Post::factory()->create([
            'title' => 'Post to delete',
            'image' => 'posts/sample_del.jpg',
        ]);
        Storage::disk('public')->put('posts/sample_del.jpg', 'fake content');

        $response = $this->delete(route('posts.destroy', $post));

        $response->assertRedirect(route('posts.index'));
        $this->assertDatabaseMissing('posts', ['id' => $post->id]);
        Storage::disk('public')->assertMissing('posts/sample_del.jpg');
    }

    public function test_api_endpoints_work_correctly(): void
    {
        Storage::fake('public');
        $file = $this->createFakeImage('api_test.gif');

        // Test API store
        $postRes = $this->postJson(route('api.posts.store'), [
            'title' => 'API Generated Post',
            'description' => 'Created via JSON API',
            'image' => $file,
            'status' => 'Active',
        ]);

        $postRes->assertStatus(201);
        $postId = $postRes->json('data.id');

        // Test API show
        $showRes = $this->getJson(route('api.posts.show', $postId));
        $showRes->assertStatus(200);
        $showRes->assertJsonFragment(['title' => 'API Generated Post']);

        // Test API index
        $indexRes = $this->getJson(route('api.posts.index'));
        $indexRes->assertStatus(200);
        $indexRes->assertJsonFragment(['total' => 1]);

        // Test API delete
        $delRes = $this->deleteJson(route('api.posts.destroy', $postId));
        $delRes->assertStatus(200);
        $this->assertDatabaseMissing('posts', ['id' => $postId]);
    }
}
