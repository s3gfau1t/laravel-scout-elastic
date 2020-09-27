<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Provider
    |--------------------------------------------------------------------------
    |
    | This option controls whether to create the Elasticesarch client with v4
    | signing for AWS or just a normal client.
    | 
    | Supported: "elasticsearch", "aws"
    |
    */

    'provider' => env('ELASTICSEARCH_PROVIDER', 'elasticsearch'),

    /*
    |--------------------------------------------------------------------------
    | Region
    |--------------------------------------------------------------------------
    |
    | Ignored if provider is elasticsearch
    |
    | Put your AWS region in here. Sure, could poll the metadata service on
    | each call, but that seems like a lot of unnecessary overhead. So put it
    | here to override .env values.
    |
    */

    'region' => env('AWS_REGION', 'us-west-2'),

    /*
    |--------------------------------------------------------------------------
    | Number of times to retry and update
    |--------------------------------------------------------------------------
    |
    | Models with a high-volume of changes (due to things like Listeners), can have
    | issues doing updates as order can get all mixed up. This parameter adjusts
    | how many times to attempt the update.
    |
    | See https://qbox.io/blog/optimistic-concurrency-control-in-elasticsearch for
    | a more in-depth explanation
    | 
    | Default: 0 (do not attempt again)
    |
    */

    'retry_on_conflict' => 0,
];
