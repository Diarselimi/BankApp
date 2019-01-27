<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BankTransactionRepository")
 */
class BankTransaction
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $uuid;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=5)
     * @Assert\NotBlank()
     * @Assert\Regex("/^\d+\.\d+/", message="Amount should be a decimal number.")
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bookingDate;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\BankTransactionPart", mappedBy="bankTransaction", cascade={"persist"})
     * @Assert\Valid()
     * @MaxDepth(1)
     */
    private $bankTransactionParts;

    public function __construct()
    {
        $this->bankTransactionParts = new ArrayCollection();
        $this->bookingDate = new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

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

    public function getBookingDate(): ?string
    {
        return $this->bookingDate->format('Y-m-d H:i:s');
    }

    public function setBookingDate(\DateTimeInterface $bookingDate): self
    {
        $this->bookingDate = $bookingDate;

        return $this;
    }

    /**
     * @return Collection|BankTransactionPart[]
     */
    public function getBankTransactionParts(): Collection
    {
        return $this->bankTransactionParts;
    }

    public function addBankTransactionPart(BankTransactionPart $bankTransactionPart): self
    {
        if (!$this->bankTransactionParts->contains($bankTransactionPart)) {
            $this->bankTransactionParts[] = $bankTransactionPart;
            $bankTransactionPart->setBankTransaction($this);
        }

        return $this;
    }

    public function removeBankTransactionPart(BankTransactionPart $bankTransactionPart): self
    {
        if ($this->bankTransactionParts->contains($bankTransactionPart)) {
            $this->bankTransactionParts->removeElement($bankTransactionPart);
            // set the owning side to null (unless already changed)
            if ($bankTransactionPart->getBankTransaction() === $this) {
                $bankTransactionPart->setBankTransaction(null);
            }
        }

        return $this;
    }
}
