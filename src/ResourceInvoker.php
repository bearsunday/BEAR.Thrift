<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceClient;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TSocket;

final class ResourceInvoker implements ResourceInvokerInterface
{
    private ResourceServiceClient $resourceService;
    private TBufferedTransport $transport;

    public function __construct(string $host, string $port)
    {
        $socket = new TSocket($host, $port);
        $this->transport = new TBufferedTransport($socket);
        $protocol = new TBinaryProtocol($this->transport);
        $this->resourceService = new ResourceServiceClient($protocol);
    }

    public function resourceInvoke(string $method, string $path, string $query = ''): ResourceResponse
    {
        $this->transport->open();
        $request = new ResourceRequest(
            [
            'method' => $method,
            'path' => $path,
            'query' => $query
            ]
        );
        $response = null;
        try {
            $response = $this->resourceService->invokeRequest($request);
        } catch (\Exception $e) {
            throw new \RuntimeException("Error invoking request: " . $e->getMessage(), 0, $e);
        } finally {
            $this->transport->close();
        }

        return $response;
    }
}
