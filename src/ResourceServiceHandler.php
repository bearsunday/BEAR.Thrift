<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\Resource;
use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceIf;
use Throwable;

use function json_encode;
use function parse_str;
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
        parse_str((string) $request->query, $query);
        $query ??= [];
        $response = new ResourceResponse();
        try {
            $uri = $this->changeHostSelf($request->path);
            $bearResponse = $this->resource->{$request->method}->uri($uri)($query);
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

    private function changeHostSelf(string $path): string
    {
        $urlParts = parse_url($path);
        if ($urlParts === false) {
            return $path;
        }

        return str_replace($urlParts['host'], 'self', $path);
    }
}
