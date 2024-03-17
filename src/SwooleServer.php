<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\ResourceInterface;
use ResourceService\ResourceServiceProcessor;
use Swoole\Server;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Transport\TMemoryBuffer;

final class SwooleServer implements ServerInterface
{
    /**
     * @inheritdoc 
     */
    public function start(ResourceInterface $resource, string $hostname, int $port): void
    {
        $server = new Server($hostname, $port);
        $factory = new TBinaryProtocolFactory();
        $server->on(
            'receive', function (Server $server, int $fd, int $reactorId, string $data) use ($resource, $factory) {
                $transport = new TMemoryBuffer($data);
                $protocol = $factory->getProtocol($transport);
                $handler = new ResourceServiceHandler($resource);
                $processor = new ResourceServiceProcessor($handler);
                $processor->process($protocol, $protocol);
                $server->send($fd, $transport->getBuffer());
            }
        );
        $server->start();
    }
}
