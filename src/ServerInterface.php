<?php

namespace BEARSunday\Thrift;

use BEAR\Resource\ResourceInterface;

interface ServerInterface
{
    /**
     * Starts the given resource with the specified hostname and port.
     *
     * @param ResourceInterface $resource The resource to start.
     * @param string            $hostname The hostname to use for the resource.
     * @param int               $port     The port number to use for the resource.
     */
    public function start(ResourceInterface $resource, string $hostname, int $port): void;
}
