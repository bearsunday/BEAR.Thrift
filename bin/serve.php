<?php

declare(strict_types=1);

use BEARSunday\Thrift\Engine;
use BEARSunday\Thrift\ServerBootstrap;
use BEARSunday\Thrift\ServerConfig;

require dirname(__DIR__) . '/tests/Fake/app/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new ServerConfig(
    appName: 'MyVendor\MyApp',
    thriftHost: '127.0.0.1',
    thriftPort: 9090,
    appDir: dirname(__DIR__) . '/tests/Fake/app',
    context: 'app',
    engine: Engine::Swoole,
);
(new ServerBootstrap())($config);
