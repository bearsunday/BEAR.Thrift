<?php

namespace MyVendor\MyApp\Resource\App;

use BEAR\Resource\ResourceObject;

final class Add extends ResourceObject
{
    public function onGet(int $a, int $b): static
    {
        $this->body = ['sum' => $a + $b];

        return $this;
    }
}
