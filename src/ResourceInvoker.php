<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceClient;
use RuntimeException;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TSocket;
use Throwable;

final class ResourceInvoker implements ResourceInvokerInterface
{
    private ResourceServiceClient $resourceService;
    private TBufferedTransport $transport;

    public function __construct(string $host, int $port)
    {
        $socket = new TSocket($host, $port);
        $this->transport = new TBufferedTransport($socket);
        $protocol = new TBinaryProtocol($this->transport);
        $this->resourceService = new ResourceServiceClient($protocol);
    }

    /** {@inheritdoc } */
    public function resourceInvoke(string $method, string $uri): ResourceResponse
    {
        $this->transport->open();
        $request = new ResourceRequest(
            [
                'method' => $method,
                'uri' => $uri,
            ],
        );
        $response = null;
        try {
            $response = $this->resourceService->invokeRequest($request);
        } catch (Throwable $e) {
            throw new RuntimeException('Error invoking request: ' . $e->getMessage(), 0, $e);
        } finally {
            $this->transport->close();
        }

        return $response;
    }
}
