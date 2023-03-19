<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes; // for soft deletes

/**
 * @OA\Schema(required={"title", "author", "genre", "isbn", "description", "published", "publisher"}, @OA\Xml(name="Book"))
 * @OA\Property(property="id", type="string", example="c85c9c7c-dbb8-4d62-b1a9-f5585ee208d6")
 * @OA\Property(property="title", type="string", example="Atomic Habits")
 * @OA\Property(property="author", type="string", example="James Clear")
 * @OA\Property(property="genre", type="string", example="Motivational")
 * @OA\Property(property="isbn", type="string", example="1234567890")
 * @OA\Property(property="description", type="string", example="An easy and proven way to build good habits and break bad ones")
 * @OA\Property(property="publisher", type="string", example="Penguin")
 * @OA\Property(property="published", type="string", format="date-time", example="2020-10-23")
 * @OA\Property(property="image", type="string", example="imageUrl")
 */
class Book extends Model
{
    use HasFactory, SoftDeletes, Uuid, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $fillable = [ 'title', 'author', 'genre', 'isbn', 'description', 'published', 'publisher', 'image' ];
 
    protected $dates = [ 'deleted_at' ];
    
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'published' => 'datetime',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];
}
