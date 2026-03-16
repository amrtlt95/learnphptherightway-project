<?php

declare(strict_types=1);

namespace App\Enums;

enum InvoiceStatus : int
{
    case pending = 0;
    case paid = 1;
}
