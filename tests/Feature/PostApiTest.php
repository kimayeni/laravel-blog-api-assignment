<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_posts_endpoint_requires_authentication()
{
    $response = $this->getJson('/api/posts');

    $response->assertStatus(401);
}

    public function test_post_creation_requires_authentication()
    {
        $response = $this->postJson('/api/posts', [
            'title' => 'Test Post',
            'content' => 'Test Content',
        ]);

        $response->assertStatus(401);
    }

    public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $response = $this->withHeader(
            'Authorization',
            'Bearer '.$token
        )->postJson('/api/posts', [
            'title' => 'My Test Post',
            'content' => 'My Test Content',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('posts', [
            'title' => 'My Test Post',
        ]);
    }


    public function test_user_cannot_update_another_users_post()
{
    $user1 = User::factory()->create();

    $user2 = User::factory()->create();

    $post = Post::factory()->create([
        'user_id' => $user2->id,
    ]);

    $token = $user1->createToken('test-token')->plainTextToken;

    $response = $this->withHeader(
        'Authorization',
        'Bearer '.$token
    )->putJson("/api/posts/{$post->id}", [
        'title' => 'Updated Title',
        'content' => 'Updated Content',
    ]);

    $response->assertStatus(403);
}
}