<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use ResourceService\ResourceResponse;

interface ResourceInvokerInterface
{
    /**
     * Invokes a resource with the given method, path, and optional query string.
     *
     * @param string $method The HTTP method to use for the resource request.
     * @param string $uri    The path of the resource to invoke.
     *
     * @return ResourceResponse The response from the resource invocation.
     */
    public function resourceInvoke(string $method, string $uri): ResourceResponse;
}
