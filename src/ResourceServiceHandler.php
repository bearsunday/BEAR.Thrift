<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\Resource;
use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceIf;
use Throwable;

use function json_encode;
use function parse_url;
use function sprintf;
use function str_replace;

/**
 * The ResourceServiceHandler class is responsible for invoking a resource request and returning the response.
 */
final class ResourceServiceHandler implements ResourceServiceIf
{
    public function __construct(
        private Resource $resource,
    ) {
    }

    /**
     * Invokes a resource request and returns the response.
     *
     * @param ResourceRequest $request The resource request object.
     *
     * @return ResourceResponse The response generated from the resource request.
     */
    public function invokeRequest(ResourceRequest $request): ResourceResponse
    {
        $response = new ResourceResponse();
        try {
            $uri = $this->changeHostSelf($request->uri);
            $bearResponse = $this->resource->{$request->method}->uri($uri)();
            $response->code = $bearResponse->code;
            $response->headers = $bearResponse->headers;
            $response->jsonValue = json_encode($bearResponse->body);
            $response->view = (string) $bearResponse;
        } catch (Throwable $e) {
            $problem = [
                'type' => $e::class,
                'title' => $e->getMessage(),
                'detail' => sprintf('thrown in %s:%s', $e->getFile(), $e->getLine()),
            ];
            $response->code = $e->getCode();
            $response->headers = ['Content-Type' => 'application/problem+json'];
            $response->jsonValue = json_encode($problem);
            $response->view = '';
        }

        return $response;
    }

    /**
     * Changes the host of a given URI to 'self'.
     */
    private function changeHostSelf(string $uri): string
    {
        $urlParts = parse_url($uri);
        if (! isset($urlParts['host'])) {
            return $uri; // relative URL
        }

        return str_replace($urlParts['host'], 'self', $uri); // change host to 'self'
    }
}
