<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SchemesTpRepository")
 */
class SchemesTp
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $schemeTpFilename;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberTP;

    /**
     * @ORM\Column(type="string")
     */
    private $descriptionTP;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSchemeTpFilename()
    {
        return $this->schemeTpFilename;
    }

    public function setSchemeTpFilename(string $schemeTpFilename)
    {
        $this->schemeTpFilename = $schemeTpFilename;

        return $this;
    }

    public function getNumberTP(): ?int
    {
        return $this->numberTP;
    }

    public function setNumberTP($numberTP): self
    {
        $this->numberTP = $numberTP;

        return $this;
    }

    public function getDescriptionTP(): ?string
    {
        return $this->descriptionTP;
    }

    public function setDescriptionTP(string $descriptionTP): self
    {
        $this->descriptionTP = $descriptionTP;

        return $this;
    }

}