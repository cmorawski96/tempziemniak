<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Article;

class ArticleTest extends TestCase
{
    use RefreshDatabase;
    public function testsArticlesAreCreatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
            'tags' => 'dolor',
            'links' => 'sin amet'
        ];

        $this->json('POST', '/api/articles', $payload, $headers)
            ->assertStatus(200)
            ->assertJson(['id' => 1, 'title' => 'Lorem', 'description' => 'Ipsum',
                'tags' => 'dolor', 'links' => 'sin amet']);
    }

    public function testsArticlesAreUpdatedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Article::class)->create([
            'title' => 'First Article',
            'description' => 'First Body',
            'tags' => 'dolor1',
            'links' => 'sin amet1'
        ]);

        $payload = [
            'title' => 'Lorem',
            'description' => 'Ipsum',
            'tags' => 'dolor',
            'links' => 'sin amet'
        ];

        $response = $this->json('PUT', '/api/articles/' . $article->id, $payload, $headers)
            ->assertStatus(200)
            ->assertJson([
                'id' => 11,
                'title' => 'Lorem',
                'description' => 'Ipsum',
                'tags' => 'dolor',
                'links' => 'sin amet'
            ]);
    }

    public function testsArtilcesAreDeletedCorrectly()
    {
        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];
        $article = factory(Article::class)->create([
            'title' => 'First Article',
            'description' => 'First Body',
            'tags' => 'dolor',
            'links' => 'sin amet'
        ]);

        $this->json('DELETE', '/api/articles/' . $article->id, [], $headers)
            ->assertStatus(204);
    }

    public function testArticlesAreListedCorrectly()
    {
        factory(Article::class)->create([
            'title' => 'First Article',
            'description' => 'First Body',
            'tags' => 'dolor',
            'links' => 'sin amet'
        ]);

        factory(Article::class)->create([
            'title' => 'Second Article',
            'description' => 'Second Body',
            'tags' => 'dolor',
            'links' => 'sin amet'
        ]);

        $user = factory(User::class)->create();
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->json('GET', '/api/articles', [], $headers)
            ->assertStatus(200)
            ->assertJson([
                [ 'title' => 'First Article', 'description' => 'First Body', 'tags' => 'dolor',
                    'links' => 'sin amet' ],
                [ 'title' => 'Second Article', 'description' => 'Second Body', 'tags' => 'dolor',
                    'links' => 'sin amet' ]
            ])
            ->assertJsonStructure([
                '*' => ['id', 'description', 'title', 'tags', 'links', 'created_at', 'updated_at'],
            ]);
    }

}
