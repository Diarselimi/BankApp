<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BankTransactionPartRepository")
 */
class BankTransactionPart
{
    const TRANSACTION_REASONS = ["debtor_payback", "bank_charge", "payment_request"];
    const UNIDENTIFIED = "unidentified";
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\BankTransaction", inversedBy="parts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $bankTransaction;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=4)
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d+\.\d+/", message="Amount should be a decimal number.")
     */
    private $amount;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\NotBlank()
     */
    private $reason;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBankTransaction(): ?BankTransaction
    {
        return $this->bankTransaction;
    }

    public function setBankTransaction(?BankTransaction $bankTransaction): self
    {
        $this->bankTransaction = $bankTransaction;

        return $this;
    }

    public function getAmount()
    {
        return $this->amount;
    }

    public function setAmount($amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getReason()
    {
        return $this->reason;
    }

    public function setReason($reason): self
    {
        $this->reason = in_array($reason, self::TRANSACTION_REASONS) ? $reason : self::UNIDENTIFIED;

        return $this;
    }

}
