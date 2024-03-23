<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

final class ServerBootstrap
{
    public function __invoke(ServerConfig $config): void
    {
        $server = new Server($config);
        $server->echoStartMessage();
        $server->start();
    }
}
