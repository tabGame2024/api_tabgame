<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\DevoirRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: DevoirRepository::class)]
#[ApiResource]
class Devoir
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'devoir')]

    #[Ignore]
    private ?Etudiant $etudiant = null;

    #[ORM\OneToMany(targetEntity: Enonce::class, mappedBy: 'devoir')]
    private Collection $enonces;

    #[ORM\ManyToOne(inversedBy: 'devoirs')]
    private ?spreadSheet $spreadsheet = null;

    #[ORM\OneToMany(targetEntity: rendu::class, mappedBy: 'devoir')]
    private Collection $rendus;

    public function __construct()
    {
        $this->enonces = new ArrayCollection();
        $this->rendus = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    public function setEtudiant(?Etudiant $etudiant): static
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * @return Collection<int, Enonce>
     */
    public function getEnonces(): Collection
    {
        return $this->enonces;
    }

    public function addEnonce(Enonce $enonce): static
    {
        if (!$this->enonces->contains($enonce)) {
            $this->enonces->add($enonce);
            $enonce->setDevoir($this);
        }

        return $this;
    }

    public function removeEnonce(Enonce $enonce): static
    {
        if ($this->enonces->removeElement($enonce)) {
            // set the owning side to null (unless already changed)
            if ($enonce->getDevoir() === $this) {
                $enonce->setDevoir(null);
            }
        }

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

    /**
     * @return Collection<int, rendu>
     */
    public function getRendus(): Collection
    {
        return $this->rendus;
    }

    public function addRendu(rendu $rendu): static
    {
        if (!$this->rendus->contains($rendu)) {
            $this->rendus->add($rendu);
            $rendu->setDevoir($this);
        }

        return $this;
    }

    public function removeRendu(rendu $rendu): static
    {
        if ($this->rendus->removeElement($rendu)) {
            // set the owning side to null (unless already changed)
            if ($rendu->getDevoir() === $this) {
                $rendu->setDevoir(null);
            }
        }

        return $this;
    }

   
}
