<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContractDetailsRepository")
 */
class ContractDetails
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $contractNumber;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nameContract;

    /**
     * @ORM\Column(type="array")
     */
    private $telephoneNumbers = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContractNumber(): ?int
    {
        return $this->contractNumber;
    }

    public function setContractNumber(int $contractNumber): self
    {
        $this->contractNumber = $contractNumber;

        return $this;
    }

    public function getNameContract(): ?string
    {
        return $this->nameContract;
    }

    public function setNameContract(string $nameContract): self
    {
        $this->nameContract = $nameContract;

        return $this;
    }

    public function getTelephoneNumbers(): ?array
    {
        return $this->telephoneNumbers;
    }

    public function setTelephoneNumbers(array $telephoneNumbers): self
    {
        $this->telephoneNumbers = $telephoneNumbers;

        return $this;
    }

}