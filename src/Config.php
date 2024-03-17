<?php

namespace BEARSunday\Thrift;

final class Config
{
    /**
     * Server config
     *
     * @param string $appName  The name of the application.
     * @param string $hostname The hostname of the server.
     * @param string $port     The port number of the server.
     * @param string $appDir   The directory where the application is located.
     * @param string $context  The context of the application.
     * @param string $server   The server information.
     */
    public function __construct(
        public string $appName,
        public string $hostname,
        public string $port,
        public string $appDir,
        public string $context,
        public Engine $server
    ) {
    }
}
