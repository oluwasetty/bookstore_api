<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Search\Searchable;
use App\Traits\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes; // for soft deletes


class Book extends Model
{
    use HasFactory, SoftDeletes, Uuid, Searchable;
 
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
}
