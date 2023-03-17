<?php

namespace App\Books;

interface BooksRepository
{
    public function search(string $query = '', $per_page);
}