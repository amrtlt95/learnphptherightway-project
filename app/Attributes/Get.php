<?php

declare(strict_types=1);

namespace App\Attributes;

use App\Enums\HttpMethod;
use Attribute;

#[Attribute()]
class Get extends Route
{
    public function __construct(public string $routePath)
    {
        parent::__construct($this->routePath, HttpMethod::Get);
    }
}
