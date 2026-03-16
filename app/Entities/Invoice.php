<?php

declare(strict_types=1);

namespace App\Entities;

use App\Enums\InvoiceStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table("invoice")]
class Invoice
{
    #[Id]
    #[Column]
    #[GeneratedValue]
    private int $id;

    #[Column(type:Types::DECIMAL, precision:10, scale:2)]
    private float $amount;

    #[Column(name:"invoice_number")]
    private string $invoiceNumber;

    #[Column]
    private InvoiceStatus $status;

    #[Column(name:"created_at")]
    private \DateTime $createdAt;

    #[OneToMany(targetEntity:InvoiceItem::class, mappedBy:"invoice", cascade:['persist',"remove"])]
    private Collection $invoiceItems;

    public function __construct()
    {
        $this->invoiceItems = new ArrayCollection();
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }


    public function getInvoiceNumber()
    {
        return $this->invoiceNumber;
    }


    public function setInvoiceNumber($invoiceNumber)
    {
        $this->invoiceNumber = $invoiceNumber;

        return $this;
    }


    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getInvoiceItems()
    {
        return $this->invoiceItems;
    }

    public function setInvoiceItems($invoiceItems)
    {
        $this->invoiceItems = $invoiceItems;

        return $this;
    }

    public function addItem(InvoiceItem $invoiceItem): self
    {
        $invoiceItem->setInvoice($this);
        $this->invoiceItems->add($invoiceItem);

        return $this;
    }
}
