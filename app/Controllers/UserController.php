<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Attributes\Get;
use App\Attributes\Post;
use App\View;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class UserController
{

    public function __construct(protected MailerInterface $mailerInterface)
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

        $text = <<<TEXT
        Hello $username,

        Thank you for joining us!
        TEXT;



        
        $html = <<<HTMLCODE
        <h1 style="color: blue; text-align: center;">Welcome to our website</h1>
        <br>
        Hello $username,
        <br>
        <br>
        Thank you for joining us!
        HTMLCODE;

        $email = (new Email())
                    ->to("placeholder@gmail.com")
                    ->from("placeholder@example.com")
                    ->subject("Welcome to our website")
                    ->text($text)
                    ->html($html);
        // $transport = Transport::fromDsn("smtp://mailHog:1025");
        // $mailer = new Mailer($transport);

        $this->mailerInterface->send($email);


    }
}