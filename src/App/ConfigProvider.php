<?php

declare(strict_types=1);

namespace App;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies(),
        ];
    }

    public function getDependencies(): array
    {
        return [
            'invokables' => [
                Handler\Ping::class      => Handler\Ping::class,
                Handler\ZipStream::class => Handler\ZipStream::class,
            ],
            'factories'  => [],
        ];
    }
}
