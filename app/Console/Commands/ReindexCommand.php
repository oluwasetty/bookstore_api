<?php

namespace App\Console\Commands;

use App\Models\Book;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Indexes all books to Elasticsearch';

    /** @var \Elasticsearch\Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();

        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Indexing all books. This might take a while...');

        foreach (Book::cursor() as $book)
        {
            
            $this->elasticsearch->index([
                'index' => $book->getSearchIndex(),
                'type' => $book->getSearchType(),
                'id' => $book->getKey(),
                'body' => $book->toSearchArray(),
            ]);

            $this->output->write('.');
        }

        $this->output->writeln('');
        $this->info('Done!');
    }
}
