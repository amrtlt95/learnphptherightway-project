<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\RawMessage;
use Symfony\Component\Mailer\Envelope;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Transport\TransportInterface;

class CustomMailer implements MailerInterface
{
    protected TransportInterface $transport;

    public function __construct(protected string $dsn)
    {
        $this->transport = Transport::fromDsn($dsn);
    }

    public function send(RawMessage $message, ?Envelope $envelope = null): void
    {
        $this->transport->send($message, $envelope);
    }

}