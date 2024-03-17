<?php

use BEAR\Resource\Module\ResourceModule;
use BEAR\Resource\ResourceInterface;
use BEARSunday\Thrift\ThriftServer;
use MyVendor\MyApp\Module\AppModule;
use Ray\Di\Injector;

require dirname(__DIR__) . '/vendor/autoload.php';

if ($argc < 3) {
    echo "Usage: php " . $argv[0] . " [hostname] [port]\n";
    exit(1);
}

$hostname = $argv[1];
$port = $argv[2];

$appName = 'MyVendor\MyApp';

$resource = (new Injector(new AppModule()))->getInstance(ResourceInterface::class);

echo "Starting the server on $hostname:$port...\n";

(new ThriftServer())->start($resource, $hostname, $port);
