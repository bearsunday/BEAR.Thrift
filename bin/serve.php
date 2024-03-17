<?php

use BEARSunday\Thrift\Config;
use BEARSunday\Thrift\Server;
use BEARSunday\Thrift\Engine;

require dirname(__DIR__) . '/tests/Fake/app/vendor/autoload.php';
require dirname(__DIR__) . '/vendor/autoload.php';

$config = new Config(
    appName: 'MyVendor\MyApp',
    hostname: '127.0.0.1',
    port: 9090,
    appDir: dirname(__DIR__) . '/tests/Fake/app',
    context: 'prod-app',
    server: Engine::Swoole
);
$server = new Server($config);
$server->echoStartMessage();
$server->start();
