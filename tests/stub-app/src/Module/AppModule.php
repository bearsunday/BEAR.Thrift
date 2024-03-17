<?php

namespace MyVendor\MyApp\Module;

use BEAR\Resource\Annotation\AppName;
use BEAR\Resource\Module\ResourceModule;
use MyVendor\MyApp\Resource\App\Add;
use Ray\Di\AbstractModule;

final class AppModule extends AbstractModule
{
    #[\Override]
    protected function configure(): void
    {
        $this->bind(Add::class);
        $this->bind()->annotatedWith(AppName::class)->toInstance('MyVendor\MyApp');
        $this->install(new ResourceModule(new ResourceModule('MyVendor\MyApp')));
    }
}
