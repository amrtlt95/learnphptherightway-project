<?php

declare(strict_types=1);

use App\App;
use App\Config;
use App\Container;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Models\EmailModel;
use App\Models\MailModel;
use App\Router;

require_once __DIR__ . '/../../vendor/autoload.php';





$container = new Container();

(new App(
    $container,
))->boot();




$container->get(EmailModel::class)->sendQueuedEmails();
