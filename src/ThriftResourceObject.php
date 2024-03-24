<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\AbstractRequest;
use BEAR\Resource\AbstractUri;
use BEAR\Resource\InvokerInterface;
use BEAR\Resource\ResourceObject;
use BEARSunday\Thrift\Exception\ThriftRemoteExecutionException;
use Symfony\Contracts\HttpClient\ResponseInterface;

use function http_build_query;
use function json_decode;
use function strtoupper;

/**
 * @method        ThriftResourceObject get(AbstractUri|string $uri, array $params = [])
 * @method        ThriftResourceObject head(AbstractUri|string $uri, array $params = [])
 * @method        ThriftResourceObject put(AbstractUri|string $uri, array $params = [])
 * @method        ThriftResourceObject post(AbstractUri|string $uri, array $params = [])
 * @method        ThriftResourceObject patch(AbstractUri|string $uri, array $params = [])
 * @method        ThriftResourceObject delete(AbstractUri|string $uri, array $params = [])
 * @property-read string                $code
 * @property-read array<string, string> $headers
 * @property-read array<string, string> $body
 * @property-read string                $view
 */
final class ThriftResourceObject extends ResourceObject
{
    /**
     * {@inheritDoc}
     */
    public $body;

    /** @psalm-suppress PropertyNotSetInConstructor */
    private ResponseInterface $response;

    public function __construct(
        private ResourceInvokerInterface $invoker,
    ) {
        unset($this->code, $this->headers, $this->body, $this->view);
    }

    public function _invokeRequest(InvokerInterface $invoker, AbstractRequest $request): ResourceObject
    {
        unset($invoker);

        $uri = $request->resourceObject->uri;
        $method = strtoupper($uri->method);
        $response = $this->invoker->resourceInvoke($method, (string) $uri, http_build_query($uri->query));
        if ($response->code >= 400) {
            throw new ThriftRemoteExecutionException($response->jsonValue, $response->code);
        }

        $this->code = $response->code;
        $this->code = $response->headers;
        $this->body = json_decode($response->jsonValue);
        $this->view = $response->view;

        return $this;
    }
}
