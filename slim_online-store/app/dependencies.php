<?php
declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return function (ContainerBuilder $containerBuilder) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $settings = $c->get('settings');

            $loggerSettings = $settings['logger'];
            $logger = new Logger($loggerSettings['name']);

            $processor = new UidProcessor();
            $logger->pushProcessor($processor);

            $handler = new StreamHandler($loggerSettings['path'], $loggerSettings['level']);
            $logger->pushHandler($handler);
prd(get_included_files(),"logger");
            return $logger;
        },//LoggerInterface::class
        
        App\Domain\User\UserRepositor::class => function (ContainerInterface $c){
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
            return $em;
            prd($em,"dependencies.php");
        },//App\Domain\User\UserRepositor::class
    ]);
};
