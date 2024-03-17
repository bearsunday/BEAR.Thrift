<?php

use BEARSunday\Thrift\ResourceServiceHandler;
use ResourceService\ResourceServiceProcessor;
use Thrift\Factory\TBinaryProtocolFactory;
use Thrift\Factory\TTransportFactory;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Server\TForkingServer;
use Thrift\Server\TServerSocket;
use Thrift\Transport\TBufferedTransport;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TSocket;

require dirname(__DIR__) . '/vendor/autoload.php';

$handler = new ResourceServiceHandler();
$processor = new ResourceServiceProcessor($handler);
$transport = new TServerSocket('localhost', 9090);
$protocolFactory = new TBinaryProtocolFactory();

$server = new TForkingServer(
    $processor,
    $transport,
    new TTransportFactory(),
    new TTransportFactory(),
    new TBinaryProtocolFactory(),
    new TBinaryProtocolFactory()
);

echo "Starting the server...\n";
$server->serve();
echo "Done.\n";
