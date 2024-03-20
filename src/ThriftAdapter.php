<?php

declare(strict_types=1);

namespace BEARSunday\Thrift;

use BEAR\Resource\AbstractUri;
use BEAR\Resource\AdapterInterface;
use BEAR\Resource\ResourceObject;

final class ThriftAdapter implements AdapterInterface
{
    public function __construct(
        private ResourceInvokerInterface $invoker,
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function get(AbstractUri $uri): ResourceObject
    {
        return new ThriftResourceObject($this->invoker);
    }
}
