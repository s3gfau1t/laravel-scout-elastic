<?php

namespace App\Console\Commands;

use Aws\ElasticsearchService\ElasticsearchPhpHandler;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class CreateIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scout:create-index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create index required for Scout';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $provider = config('laravel-scout-elastic.provider', 'elastic');

        switch ($provider) {
            case 'aws':
                // Create a handler (with the region of your Amazon Elasticsearch Service domain)
                $handler = new ElasticsearchPhpHandler(config('laravel-scout-elastic.region', 'us-west-2'));

                // Use this handler to create an Elasticsearch-PHP client
                $client = ClientBuilder::create()
                    ->setHandler($handler)
                    ->setHosts(config('scout.elasticsearch.hosts'))
                    ->build();

                break;
            case 'elastic':
            default:
                $client = ClientBuilder::create()
                    ->setHosts(config('scout.elasticsearch.hosts'))
                    ->build();

                break;
        }

        foreach (config('scout.elasticsearch.indexes') as $index) {
            if (! $client->indices()->exists(['index' => $index])) {
                $params = [
                    'index' => $index,
                ];
                $client->indices()->create($params);
            }
        }
    }
}
