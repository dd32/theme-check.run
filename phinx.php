<?php

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/database/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/database/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'migrations',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => getenv('DATABASE_HOST'),
            'port' => getenv('DATABASE_PORT'),
            'name' => getenv('DATABASE_NAME'),
            'user' => getenv('DATABASE_USER'),
            'pass' => getenv('DATABASE_PASS'),
            'charset' => 'utf8',
        ]
    ],
    'version_order' => 'creation'
];
