<?php

use BEARSunday\Thrift\ServerConfig;
use BEARSunday\Thrift\ThriftApp;
use BEARSunday\Thrift\Server;
use BEARSunday\Thrift\Engine;

require dirname(__DIR__) . '/tests/Fake/app/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new ServerConfig(
    appName: 'MyVendor\MyApp',
    thriftHost: '127.0.0.1',
    thriftPort: 9090,
    appDir: dirname(__DIR__) . '/tests/Fake/app',
    context: 'app',
    engine: Engine::Swoole
);
$server = new Server($config);
$server->echoStartMessage();
$server->start();
