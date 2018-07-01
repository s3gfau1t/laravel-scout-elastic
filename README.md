# Laravel Scout Elasticsearch Driver

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package makes is the [Elasticsearch](https://www.elastic.co/products/elasticsearch) driver for Laravel Scout that works with AWS' Elasticsearch and does not require you to put credentials into .env files.

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require tamayo/laravel-scout-elastic
```

You must add the Scout service provider and the package service provider in your app.php config:

```php
// config/app.php
'providers' => [
    ...
    Laravel\Scout\ScoutServiceProvider::class,
    ...
    ScoutEngines\Elasticsearch\ElasticsearchProvider::class,
],
```

## Configuration

This package assumes you are following good AWS security and /not/ putting password in your Laravel .env files an instead follows the practices outlined in [Credentials for the AWS SDK for PHP Version 3](https://docs.aws.amazon.com/sdk-for-php/v3/developer-guide/guide_credentials.html). To enable this, set the following variable in your .env.

```php
ELASTICSEARCH_PROVIDER=aws
```

For local development, inside vagrant for instance, you can use the normal Elasticsearch client by either omitting this variable or setting it as follows.

```php
ELASTICSEARCH_PROVIDER=elastic
```

One thing the AWS client needs is the Region. If you don't already have it in your .env, add it as such.

```php
AWS_REGION=us-west-2
```

## Testing with Scout

If your CI environment does not have access to a working Elasticsearch instance, any indexed Models will cause it to error. To solve this, add the following to your phpunit.xml. The single quotes wrapping the double quotes are the tricky part there.

```xml
<env name="SCOUT_DRIVER" value='"null"' />
```

### Setting up Elasticsearch configuration
You must have a Elasticsearch server up and running with the index you want to use created.

If the index doesn't exist, add 


```php
// App/Console/Kernel.php
protected $commands = [
    ...
    App\Console\Commands\CreateIndex::class
    ...
],
```

If you need help with this please refer to the [Elasticsearch documentation](https://www.elastic.co/guide/en/elasticsearch/reference/current/index.html)

After you've published the Laravel Scout package configuration:

```php
// config/scout.php
// Set your driver to elasticsearch
    'driver' => env('SCOUT_DRIVER', 'elasticsearch'),

...
    'elasticsearch' => [
        'index' => env('ELASTICSEARCH_INDEX', 'laravel'),
        'hosts' => [
            env('ELASTICSEARCH_HOST', 'http://localhost'),
        ],
    ],
...
```

## Usage

Now you can use Laravel Scout as described in the [official documentation](https://laravel.com/docs/5.3/scout)
## Credits

- [Erick Tamayo](https://github.com/ericktamayo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT).
