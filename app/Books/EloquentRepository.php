<?php

namespace App\Books;

use App\Models\Book;

class EloquentRepository implements BooksRepository
{
    public function search(string $q = '', $per_page)
    {
        $books = Book::query()
        ->where(fn ($query) => (
            $query->where('title', 'LIKE', "%{$q}%")
                ->orWhere('author', 'LIKE', "%{$q}%")
                ->orWhere('genre', 'LIKE', "%{$q}%")
                ->orWhere('isbn', 'LIKE', "%{$q}%")
                ->orWhere('published', 'LIKE', "%{$q}%")
        ))
        ->paginate($per_page);
        return $books;
    }
}