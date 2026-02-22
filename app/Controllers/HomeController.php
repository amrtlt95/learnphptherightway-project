<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\InvoiceService;
use App\View;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }
    public function index(): View
    {
        $result = $this->invoiceService->process([], 150);
        if ($result === true) {
            echo "invoice proccesed";
            echo nl2br(PHP_EOL);
        }
        return View::make('index');
    }
}
