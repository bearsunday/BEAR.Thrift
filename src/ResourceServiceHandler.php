<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use ResourceService\ResourceRequest;
use ResourceService\ResourceResponse;
use ResourceService\ResourceServiceIf;
use function json_encode;
use function parse_str;

final class ResourceServiceHandler implements ResourceServiceIf
{
    public function invokeRequest(ResourceRequest $request): ResourceResponse
    {
        // for testing
        parse_str($request->query, $query);
        $sum =  $query['a'] + $query['b'];
        $response = new ResourceResponse();
        $response->code = 200;
        $response->headers = ['Content-Type' => 'text/html; charset=UTF-8'];
        $response->jsonValue = json_encode(['sum' => $sum]);
        $response->view = "{$query['a']} + {$query['b']} = {$sum}";

        return $response;
    }
}
