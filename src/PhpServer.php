<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\ResourceInterface;
use ResourceService\ResourceServiceProcessor;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Server\TForkingServer;
use Thrift\Server\TServerSocket;

final class PhpServer implements ServerInterface
{
    /** @inheritdoc */
    public function start(ResourceInterface $resource, string $hostname, int $port): void
    {
        $handler = new ResourceServiceHandler($resource);
        $processor = new ResourceServiceProcessor($handler);

        $transport = new TServerSocket($hostname, $port);
        $transportFactory = new TTransportFactory();
        $protocolFactory = new TBinaryProtocolFactory();

        $server = new TForkingServer(
            $processor,
            $transport,
            $transportFactory,
            $transportFactory,
            $protocolFactory,
            $protocolFactory,
        );
        $server->serve();
    }
}
