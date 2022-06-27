<?php

declare(strict_types=1);

use Mezzio\Application;
use Mezzio\MiddlewareFactory;
use Psr\Container\ContainerInterface;

return static function (
    Application $app,
    MiddlewareFactory $factory,
    ContainerInterface $container
): void {
    $app->get(
        '/api/ping',
        App\Handler\Ping::class,
        'api.ping'
    );

    $app->get(
        '/api/zip-stream',
        App\Handler\Zip::class,
        'api.zip-stream'
    );
};
