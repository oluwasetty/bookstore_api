<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;
use App\Models\User;

class BookTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    /**
     * Test GET all endpoint.
     *
     * @return void
     */
    public function testGetAllEndpoint()
    {
        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response = $this->get('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    [
                        "id",
                        "title",
                        "author",
                        "genre",
                        "isbn",
                        "description",
                        "publisher",
                        "image",
                        "created_at",
                        "updated_at",
                    ],
                ],
                "links" => [
                    "first",
                    'last',
                    'prev',
                    'next',
                ],
                "meta" => [
                    'total',
                    'last_page',
                    'per_page',
                    'current_page',
                    'from',
                    'to'
                ],
                "status",
                "message"
            ]);
    }

    /**
     * Test GET one endpoint.
     *
     * @return void
     */
    public function testGetOneEndpoint()
    {
        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);
        
        $response = $this->get("/api/books/$book->id", [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                    "id",
                    "title",
                    "author",
                    "genre",
                    "isbn",
                    "description",
                    "publisher",
                    "image",
                    "created_at",
                    "updated_at",
            ],
            "status",
            "message"
        ]);
    }

    /**
     * Test POST endpoint.
     *
     * @return void
     */
    public function testPostEndpoint()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email(),
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user, 'api');

        $response = $this->post('/api/books', [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response->assertStatus(201)
        ->assertJsonStructure([
            "data" => [
                    "id",
                    "title",
                    "author",
                    "genre",
                    "isbn",
                    "description",
                    "publisher",
                    "image",
                    "created_at",
                    "updated_at",
            ],
            "status",
            "message"
        ]);
    }

    /**
     * Test PUT endpoint.
     *
     * @return void
     */
    public function testPutEndpoint()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email(),
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user, 'api');

        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response = $this->put("/api/books/$book->id", [
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response->assertStatus(200)
        ->assertJsonStructure([
            "data" => [
                    "id",
                    "title",
                    "author",
                    "genre",
                    "isbn",
                    "description",
                    "publisher",
                    "image",
                    "created_at",
                    "updated_at",
            ],
            "status",
            "message"
        ]);
    }

    /**
     * Test DELETE endpoint.
     *
     * @return void
     */
    public function testDeleteEndpoint()
    {
        $user = User::factory()->create([
            'email' => $this->faker->email(),
            'password' => bcrypt('password'),
        ]);
        $this->actingAs($user, 'api');
        
        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response = $this->delete("/api/books/$book->id");
        
        $response->assertStatus(200)
        ->assertJsonStructure([
            "status",
            "message"
        ]);
    }

    /**
     * Test Search endpoint.
     *
     * @return void
     */
    public function testSeachEndpoint()
    {
        $book = Book::factory()->create([
            'title' => $this->faker->words(3, true),
            'author' => $this->faker->name(),
            'genre' => $this->faker->words(2, true),
            'isbn' => $this->faker->numberBetween(100000000000000, 999999999999999),
            'description' => $this->faker->paragraph(),
            'publisher' => $this->faker->words(2, true),
            'image' => "http://placeimg.com/480/640/any",
            'published' => "2020-10-02",
        ]);

        $response = $this->get("/api/search-books?q=$book->title");
        // dd($response);

        $response->assertStatus(200)
            ->assertJsonStructure([
                "data" => [
                    [
                        "id",
                        "title",
                        "author",
                        "genre",
                        "isbn",
                        "description",
                        "publisher",
                        "image",
                        "created_at",
                        "updated_at",
                    ],
                ],
                "links" => [
                    "first",
                    'last',
                    'prev',
                    'next',
                ],
                "meta" => [
                    'total',
                    'last_page',
                    'per_page',
                    'current_page',
                    'from',
                    'to'
                ],
                "status",
                "message"
            ]);
    }
}
