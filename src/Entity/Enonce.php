<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\EnonceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnonceRepository::class)]
#[ApiResource]
class Enonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'enonces')]
    #[ORM\JoinColumn(nullable: false)]
    private ?devoir $devoir = null;

    #[ORM\ManyToOne(inversedBy: 'enonces')]
    private ?spreadSheet $spreadsheet = null;

    #[ORM\ManyToOne(inversedBy: 'enonces')]
    private ?chapitre $chapitre = null;

    #[ORM\Column(length: 255)]
    private ?string $nomEnonce = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDevoir(): ?devoir
    {
        return $this->devoir;
    }

    public function setDevoir(?devoir $devoir): static
    {
        $this->devoir = $devoir;

        return $this;
    }

    public function getSpreadsheet(): ?spreadSheet
    {
        return $this->spreadsheet;
    }

    public function setSpreadsheet(?spreadSheet $spreadsheet): static
    {
        $this->spreadsheet = $spreadsheet;

        return $this;
    }

    public function getChapitre(): ?chapitre
    {
        return $this->chapitre;
    }

    public function setChapitre(?chapitre $chapitre): static
    {
        $this->chapitre = $chapitre;

        return $this;
    }

    public function getNomEnonce(): ?string
    {
        return $this->nomEnonce;
    }

    public function setNomEnonce(string $nomEnonce): static
    {
        $this->nomEnonce = $nomEnonce;

        return $this;
    }

}
