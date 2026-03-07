<?php

declare(strict_types=1);

namespace App\Services;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    public function __construct(protected MailerInterface $mailer)
    {
    }
    public function send(string $to, string $from, string $subject, string $text_body, string $html_body): void
    {
         $email = (new Email())
                    ->to($to)
                    ->from($from)
                    ->subject($subject)
                    ->text($text_body)
                    ->html($html_body);

        $this->mailer->send($email);
    }
}
