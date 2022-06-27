<?php

declare(strict_types=1);

namespace App\Handler;

use Laminas\Diactoros\CallbackStream;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZipStream\Option\Archive;

use function dirname;
use function file_get_contents;
use function sprintf;

class ZipStream implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $dataPath = dirname(__DIR__, 3);
        $items    = [
            'A.pdf' => file_get_contents($dataPath . '/data/A.pdf'),
            'B.pdf' => file_get_contents($dataPath . '/data/B.pdf'),
            'C.pdf' => file_get_contents($dataPath . '/data/C.pdf'),
        ];

        $zipName = 'test.zip';

        $stream = new CallbackStream(static function () use ($items, $zipName) {
            $options = new Archive();
            $options->setContentType('application/octet-stream');

            $zip = new \ZipStream\ZipStream($zipName, $options);

            foreach ($items as $basename => $content) {
                $zip->addFile($basename, $content);
            }

            $zip->finish();
        });

        $headers = [
            'Cache-Control'       => 1200,
            'Content-Type'        => 'application/octet-stream',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $zipName),
        ];

        return new Response($stream, 200, $headers);
    }
}
