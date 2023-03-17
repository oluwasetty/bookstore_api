<?php

namespace App\Books;

use App\Models\Book;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

class ElasticsearchRepository implements BooksRepository
{
    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    public function __construct(Client $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function search(string $query = '', $per_page)
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(string $query = ''): array
    {
        $model = new Book;

        $items = $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => [
                    'multi_match' => [
                        'fields' => ['title^5', 'body', 'tags'],
                        'query' => $query,
                    ],
                ],
            ],
        ]);

        return $items;
    }

    private function buildCollection(array $items)
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Book::findMany($ids)
            ->sortBy(function ($book) use ($ids) {
                return array_search($book->getKey(), $ids);
            });
    }
}