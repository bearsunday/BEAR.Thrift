<?php

declare(strict_types=1);

namespace MyVendor\MyApp\Module;

use BEAR\Resource\ResourceInterface;
use BEAR\Sunday\Extension\Application\AppInterface;
use BEAR\Sunday\Extension\Error\ThrowableHandlerInterface;
use BEAR\Sunday\Extension\Router\RouterInterface;
use BEAR\Sunday\Extension\Transfer\HttpCacheInterface;
use BEAR\Sunday\Extension\Transfer\TransferInterface;

final class App implements AppInterface
{
    public function __construct(
        public readonly ResourceInterface $resource,
    ) {
    }
}
