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
    private $txnType;

    #[ORM\Column(type: 'integer')]
    private $txnId;

    #[ORM\Column(type: 'integer')]
    private $amount;

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

    public function getTxnType(): ?string
    {
        return $this->txnType;
    }

    public function setTxnType(string $txnType): self
    {
        $this->txnType = $txnType;

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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }
}
