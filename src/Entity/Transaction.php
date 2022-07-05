<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'datetime')]
    private $txnDate;

    #[ORM\Column(type: 'string', length: 100)]
    private $customerName;

    #[ORM\Column(type: 'string', length: 100)]
    private $productName;

    #[ORM\Column(type: 'string', length: 100)]
    private $txnType;

    #[ORM\Column(type: 'integer')]
    private $qty;

    #[ORM\Column(type: 'integer')]
    private $price;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $vat;

    #[ORM\Column(type: 'integer')]
    private $amount;

    #[ORM\Column(type: 'integer')]
    private $txnId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTxnDate(): ?\DateTimeInterface
    {
        return $this->txnDate;
    }

    public function setTxnDate(\DateTimeInterface $txnDate): self
    {
        $this->txnDate = $txnDate;

        return $this;
    }

    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    public function setCustomerName(string $customerName): self
    {
        $this->customerName = $customerName;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getTxnType(): ?string
    {
        return $this->txnType;
    }

    public function setTxnType(string $txnType): self
    {
        $this->txnType = $txnType;

        return $this;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getVat(): ?int
    {
        return $this->vat;
    }

    public function setVat(?int $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getTxnId(): ?int
    {
        return $this->txnId;
    }

    public function setTxnId(int $txnId): self
    {
        $this->txnId = $txnId;

        return $this;
    }
}
