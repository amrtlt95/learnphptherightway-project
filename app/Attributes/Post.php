<?php

declare(strict_types=1);

namespace App\Attributes;

use Attribute;

#[Attribute()]
class Post extends Route
{
    public function __construct(public string $routePath)
    {
        parent::__construct($this->routePath, "post");
    }
}
