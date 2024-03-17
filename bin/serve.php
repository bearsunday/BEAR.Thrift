<?php

use BEARSunday\Thrift\ResourceServiceHandler;
use ResourceService\ResourceServiceProcessor;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Server\TForkingServer;
use Thrift\Server\TServerSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

if ($argc < 3) {
    echo "Usage: php " . $argv[0] . " [hostname] [port]\n";
    exit(1);
}

$hostname = $argv[1];
$port = $argv[2];

$handler = new ResourceServiceHandler();
$processor = new ResourceServiceProcessor($handler);

$transport = new TServerSocket($hostname, $port);
$protocolFactory = new TBinaryProtocolFactory();

$server = new TForkingServer(
    $processor,
    $transport,
    new TTransportFactory(),
    new TTransportFactory(),
    new TBinaryProtocolFactory(),
    new TBinaryProtocolFactory()
);

echo "Starting the server on $hostname:$port...\n";
$server->serve();
echo "Done.\n";
