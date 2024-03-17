<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\Resource;
use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceIf;
use function json_encode;
use function parse_str;
use function var_dump;

final class ResourceServiceHandler implements ResourceServiceIf
{
    public function __construct(
        private Resource $resource
    ) {
    }

    public function invokeRequest(ResourceRequest $request): ResourceResponse
    {
        parse_str($request->query, $query);
        $bearResponse = $this->resource->{$request->method}->uri($request->path)($query);
        $response = new ResourceResponse();
        $response->code = $bearResponse->code;
        $response->headers = $bearResponse->headers;
        $response->jsonValue = json_encode($bearResponse->body);
        $response->view = (string) $bearResponse;

        return $response;
    }
}
