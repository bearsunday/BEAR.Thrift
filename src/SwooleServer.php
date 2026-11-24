<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\ResourceInterface;
use ResourceService\ResourceServiceProcessor;
use Swoole\Server;
use Thrift\Exception\TApplicationException;
use Thrift\Exception\TException;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Transport\TMemoryBuffer;
use Thrift\Type\TMessageType;

final class SwooleServer implements ServerInterface
{
    /** @inheritdoc */
    public function start(ResourceInterface $resource, string $hostname, int $port): void
    {
        $server = new Server($hostname, $port);
        $factory = new TBinaryProtocolFactory();
        $handler = new ResourceServiceHandler($resource);
        $processor = new ResourceServiceProcessor($handler);
        $server->on(
            'receive',
            static function (Server $server, int $fd, int $reactorId, string $data) use ($factory, $processor): void {
                $transport = new TMemoryBuffer($data);
                $protocol = $factory->getProtocol($transport);
                try {
                    $processor->process($protocol, $protocol);
                } catch (TException $e) {
                    // Uncaught, it would end the worker: the whole server in the default SWOOLE_BASE mode
                    $server->send($fd, self::errorReply($factory, $data, $e));

                    return;
                }

                $server->send($fd, $transport->getBuffer());
            },
        );
        $server->start();
    }

    private static function errorReply(TBinaryProtocolFactory $factory, string $data, TException $e): string
    {
        $name = '';
        $type = 0;
        $seqid = 0;
        try {
            $factory->getProtocol(new TMemoryBuffer($data))->readMessageBegin($name, $type, $seqid);
        } catch (TException) {
            $name = '';
            $seqid = 0;
        }

        $transport = new TMemoryBuffer();
        $protocol = $factory->getProtocol($transport);
        $protocol->writeMessageBegin($name, TMessageType::EXCEPTION, $seqid);
        (new TApplicationException($e->getMessage(), TApplicationException::PROTOCOL_ERROR))->write($protocol);
        $protocol->writeMessageEnd();

        return $transport->getBuffer();
    }
}
