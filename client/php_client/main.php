<?php

use BEARSunday\Thrift\ResourceInvoke;
use ResourceService\ResourceResponse;

require dirname(__DIR__, 2) . '/vendor/autoload.php';

(function(string $host, string $port, string $method, string $uri): void {
    $invoke = new ResourceInvoke($host, $port);
    $response = $invoke($method, $uri);
    assert($response instanceof ResourceResponse);
    printf("Response Code: %s\n", $response->code);
    printf("Response Headers: %s\n", json_encode($response->headers));
    printf("Raw Response JsonValue: : %s\n", $response->jsonValue);
    printf("Response View: %s\n", $response->view);
})(
    '127.0.0.1',
    9090,
    'get',
    '/?name=Workd!'
);
