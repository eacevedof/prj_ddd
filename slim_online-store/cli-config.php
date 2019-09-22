<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require 'vendor/autoload.php';

$settings = [
    'meta' => [
        'entity_path' => [
            //'app/src/Entity'
            'entities'
        ],
        'auto_generate_proxies' => true,
        'proxy_dir' =>  __DIR__.'/../cache/proxies',
        'cache' => null,
    ],
    //https://blog.sub85.com/slim-3-with-doctrine-2.html
    'connection' => [
        'driver'   => 'pdo_mysql',
        'host'     => 'localhost',
        'dbname'   => 'db_slimstore',
        'user'     => 'homestead',
        'password' => 'secret',
    ]
];

$config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
    $settings['meta']['entity_path'],
    $settings['meta']['auto_generate_proxies'],
    $settings['meta']['proxy_dir'],
    $settings['meta']['cache'],
    false
);

$em = \Doctrine\ORM\EntityManager::create($settings['connection'], $config);

return ConsoleRunner::createHelperSet($em);