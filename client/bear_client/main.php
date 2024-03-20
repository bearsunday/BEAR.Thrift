<?php

namespace MyVendor\Greeting;

use BEAR\Resource\Module\ResourceModule;
use BEAR\Resource\ResourceInterface;
use BEARSunday\Thrift\ImportThriftAppModule;
use BEARSunday\Thrift\ThriftApp;
use Ray\Di\AbstractModule;
use Ray\Di\Injector;
use function dirname;

require dirname(__DIR__, 2) . '/vendor/autoload.php';
require __DIR__ . '/vendor/autoload.php';

$injector = new Injector(new class() extends AbstractModule
{
    protected function configure(): void
    {
        $this->install(new ResourceModule('MyVendor\Greeting'));
        $this->override(new ImportThriftAppModule([
            new ThriftApp('sekai', '127.0.0.1', 9090)
        ]));
    }
});
$resource = $injector->getInstance(ResourceInterface::class);

echo $resource->get('page://self/?name=Sekai');  // "greeting": "Konichiwa Sekai" from local app
echo $resource->get('page://sekai/?name=World'); // "greeting": "Hello World" from remote(127.0.0.1:9090) app

