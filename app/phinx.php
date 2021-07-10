<?php

use App\Infrastructure\Slim\Setting\ConfigLoader;

$configLoader = new ConfigLoader(__DIR__ . "/env/env.json");

return [
    "paths" => [
        "migrations" => [
            'App\Migrations' => __DIR__ . "/migrations"
        ],
        "seeds" => [
            'App\Seeds' => __DIR__ . "/seeds"
        ],
    ],
    "environments" => [
        "default_migration_table" => "got_migrations",
        "default_database" => 'db',
        "db" => [
            "adapter" => "mysql",
            "host" => $configLoader->get('DB_HOSTNAME'),
            "name" => $configLoader->get('DB_DATABASE'),
            "user" => $configLoader->get('DB_USERNAME'),
            "pass" => $configLoader->get('DB_PASSWORD'),
            "port" => $configLoader->get('DB_PORT')
        ]
    ]
];
