<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

final class ServerConfig
{
    public function __construct(
        public string $appName,
        public string $context,
        public string $appDir,
        public string $thriftHost,
        public int $thriftPort,
        public Engine $engine,
    ) {
    }
}
