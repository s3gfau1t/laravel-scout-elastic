<?php

namespace ScoutEngines\Elasticsearch;

use Aws\Credentials\CredentialProvider;
use Aws\Credentials\Credentials;
use Aws\ElasticsearchService\ElasticsearchPhpHandler;
use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class ElasticsearchProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../commands/CreateIndex.php' => app_path('Console/Commands/CreateIndex.php'),
            __DIR__ . '/../config/laravel-scout-elastic.php' => config_path('laravel-scout-elastic.php'),
        ]);

        $provider = config('laravel-scout-elastic.provider', 'elastic');

        switch ($provider) {
            case 'aws':
                app(EngineManager::class)->extend('elasticsearch', function($app) {
                    $provider = CredentialProvider::defaultProvider();
                    $handler = new ElasticsearchPhpHandler(config('laravel-scout-elastic.region', 'us-west-2'), $provider);
                    return new ElasticsearchEngine(ElasticBuilder::create()
                        ->setHandler($handler)
                        ->setHosts(config('scout.elasticsearch.hosts'))
                        ->build(),
                        config('scout.elasticsearch.index')
                    );
                });
                break;
            case 'elastic':
            default:
                app(EngineManager::class)->extend('elasticsearch', function($app) {
                    return new ElasticsearchEngine(ElasticBuilder::create()
                        ->setHosts(config('scout.elasticsearch.hosts'))
                        ->build(),
                        config('scout.elasticsearch.index')
                    );
                });
                break;
        }
    }
}
