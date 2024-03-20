<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

final class ThriftApp
{
    public function __construct(
        public string $host,
        public string $thriftHost,
        public int $thriftPort,
    ) {
    }
}
