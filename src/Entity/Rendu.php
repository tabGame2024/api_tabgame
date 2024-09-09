<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\RenduRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RenduRepository::class)]
#[ApiResource]
class Rendu
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'rendus')]
    private ?Devoir $devoir = null;

    #[ORM\ManyToOne(inversedBy: 'rendus')]
    private ?SpreadSheet $spreadSheet = null;

    #[ORM\Column]
    private ?int $validation = null;

    #[ORM\Column]
    private ?int $appreciation = null;

   


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevoir(): ?Devoir
    {
        return $this->devoir;
    }

    public function setDevoir(?Devoir $devoir): static
    {
        $this->devoir = $devoir;

        return $this;
    }

    public function getSpreadSheet(): ?SpreadSheet
    {
        return $this->spreadSheet;
    }

    public function setSpreadSheet(?SpreadSheet $spreadSheet): static
    {
        $this->spreadSheet = $spreadSheet;

        return $this;
    }

    public function getValidation(): ?int
    {
        return $this->validation;
    }

    public function setValidation(int $validation): static
    {
        $this->validation = $validation;

        return $this;
    }

    public function getAppreciation(): ?int
    {
        return $this->appreciation;
    }

    public function setAppreciation(int $appreciation): static
    {
        $this->appreciation = $appreciation;

        return $this;
    }


}
