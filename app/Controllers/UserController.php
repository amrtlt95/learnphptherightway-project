<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\Models\EmailModel;
use App\Services\EmailService;
use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class UserController
{

    public function __construct(protected EmailModel $email_model, protected EmailService $email_service)
    {
    }

    #[Get("/users/create")]
    public function create()
    {
        return View::make("users/create");
    }

    #[Post("/users/create")]
    public function store()
    {
        $username = $_POST["username"];
        $password = $_POST["password"];


        $text = <<<Body
Hello $username,

Thank you for signing up!
Body;

        $html = <<<HTMLBody
<h1 style="text-align: center; color: blue;">Welcome</h1>
Hello $username,
<br /><br />
Thank you for signing up!
HTMLBody;


        $this->email_model->queue(
            new Address("test@test.com", "Amr Talaat"),
            new Address("test@test.com", "Application"),
            "Welcome",
            $text,
            $html
        );
    }
}