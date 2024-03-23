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
     * @param string $path   The path of the resource to invoke.
     * @param string $query  (optional) The query string to append to the resource path. Defaults to an empty string.
     *
     * @return ResourceResponse The response from the resource invocation.
     */
    public function resourceInvoke(string $method, string $path, string $query = ''): ResourceResponse;
}
