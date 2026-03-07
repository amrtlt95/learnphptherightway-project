<?php

declare(strict_types=1);

namespace App\Enums;

enum EmailStatus : int
{
    case pending = 0;
    case sent = 1;
    case failed = 2;

    public function getEmailStatus(): string
    {
        return match ($this) {
            self::pending => "Pending",
            self::sent => "Sent",
            default => "Failed"
        };
    }
}
