<?php

declare(strict_types=1);

namespace App\Exceptions\Containers;

use Psr\Container\ContainerExceptionInterface;

class NotFoundException extends \Exception implements ContainerExceptionInterface
{
    protected $message = 'The requested class has no entry in the container.';
}
