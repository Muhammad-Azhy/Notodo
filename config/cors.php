<?php
return [

    'paths' => ['api/*'],  // enable CORS for all API routes

    'allowed_methods' => ['*'],  // allow GET, POST, PUT, DELETE etc.

    'allowed_origins' => ['*'],  // allow all origins (for dev)
    // Or better: ['http://localhost:57481'] for your Flutter web

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // allow all headers

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // needed for Sanctum auth
];

