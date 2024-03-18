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
        $handler = new ResourceServiceHandler($resource);
        $processor = new ResourceServiceProcessor($handler);
        $server->on(
            'receive', function (Server $server, int $fd, int $reactorId, string $data) use ($resource, $factory, $processor) {
                $transport = new TMemoryBuffer($data);
                $protocol = $factory->getProtocol($transport);
                $processor->process($protocol, $protocol);
                $server->send($fd, $transport->getBuffer());
            }
        );
        $server->start();
    }
}
