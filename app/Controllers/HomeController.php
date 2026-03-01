<?php

declare(strict_types = 1);

namespace App\Controllers;

use App\Services\InvoiceService;
use App\View;
use App\Attributes\Route;
use App\Attributes\Get;
use App\Attributes\Post;

class HomeController
{
    public function __construct(private InvoiceService $invoiceService)
    {
    }

    // #[Route("/", "get")]
    #[Get("/")]
    public function index(): View
    {
        $this->invoiceService->process([], 25);

        return View::make('index');
    }

    #[Post("/store")]
    public function store()
    {
    }
}
