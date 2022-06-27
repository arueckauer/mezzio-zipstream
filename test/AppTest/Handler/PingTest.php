<?php

declare(strict_types=1);

namespace AppTest\Handler;

use App\Handler\Ping;
use Laminas\Diactoros\Response\JsonResponse;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;

use function json_decode;

class PingTest extends TestCase
{
    public function testResponse(): void
    {
        $pingHandler = new Ping();
        $response    = $pingHandler->handle(
            $this->createMock(ServerRequestInterface::class)
        );

        $json = json_decode((string) $response->getBody());

        self::assertInstanceOf(JsonResponse::class, $response);
        self::assertTrue(isset($json->ack));
    }
}
