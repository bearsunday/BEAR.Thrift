<?php

declare(strict_types=1);

namespace MyVendor\Greeting\Resource\Page;

use BEAR\Resource\ResourceObject;

class Index extends ResourceObject
{
    /**
     * @var array{greeting: string} 
     */
    public $body;

    public function onGet(string $name = 'BEAR.Sunday'): static
    {
        $this->body = [
            'greeting' => 'Konichiwa ' . $name,
        ];

        return $this;
    }
}
