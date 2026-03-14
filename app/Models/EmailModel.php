<?php

declare(strict_types=1);

namespace App\Models;

use App\DB;
use App\Enums\EmailStatus;
use App\Services\EmailService;
use Symfony\Component\Mime\Address;

class EmailModel extends Model
{
    public function __construct(protected EmailService $emailService)
    {
        parent::__construct();
    }
    public function queue(Address $to, Address $from, string $subject, string $text_body, string $html_body): void
    {
        $meta["to"] = $to->toString();
        $meta["from"] = $from->toString();


        /*
        subject, status, text_body, html_body, meta, created_at, sent_at
        */
        $query = "INSERT INTO emails (subject, status, text_body, html_body, meta, created_at)
                    VALUES (:subject, :status, :text_body, :html_body, :meta, NOW())";
        $stmt = $this->db->prepare($query);

        $stmt->execute([
            ":subject" => $subject,
            ":status" => EmailStatus::pending->value,
            ":text_body" => $text_body,
            ":html_body" => $html_body,
            ":meta" => \json_encode($meta)
        ]);
    }

    public function getQueuedEmails(): array
    {
        $query = "SELECT *
                    FROM emails
                    WHERE status = :status";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            ":status" => EmailStatus::pending->value
        ]) ;

        return $stmt->fetchAll();
    }

    public function sendQueuedEmails(): void
    {
        $emails = $this->getQueuedEmails();

        foreach ($emails as $email) {
            $meta = json_decode($email['meta'], true);
            $this->emailService->send($meta['to'], $meta['from'], $email['subject'], $email['text_body'], $email['html_body']);
            $this->updateEmailStatusToSent($email['id']);
        }
    }

    private function updateEmailStatusToSent(int $id): void
    {
        $query = "UPDATE emails
                    SET
                    status = :status,
                    sent_at =  NOW()
                    WHERE id = :id";

        $stmt = $this->db->prepare($query);

        $stmt->execute([
            "status" => EmailStatus::sent->value,
            ":id" => $id
        ]);
    }
}
