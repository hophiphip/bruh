<?php

namespace App\Console\Commands;

use App\Models\Offer;
use Elasticsearch\Client;
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
    protected $description = 'Index all offers to Elasticsearch';

    /**
     * @var Client elasticsearch client
     */
    private Client $elasticsearch;

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
     * @return int
     */
    public function handle(): int
    {
        $this->info('Indexing offers...');

        $bar = $this->output->createProgressBar(Offer::count());
        $bar->start();

        foreach (Offer::cursor() as $offer)
        {
            $this->elasticsearch->index([
                'index' => $offer->getSearchIndex(),
                'type' => $offer->getSearchType(),
                'id' => $offer->getKey(),
                'body' => $offer->toSearchArray(),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->output->newLine();

        return 0;
    }
}
