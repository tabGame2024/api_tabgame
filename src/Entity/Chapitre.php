<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ChapitreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ChapitreRepository::class)]
#[ApiResource(
    normalizationContext:["groups"=> ["read:collection"]]
)]
class Chapitre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:collection'])]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Enonce::class, mappedBy: 'chapitre')]
    private Collection $enonces;

    #[ORM\ManyToMany(targetEntity: formations::class, inversedBy: 'chapitres')]
    private Collection $formations;

    #[ORM\Column(length: 255)]
    private ?string $nomChapitre = null;

    public function __construct()
    {
        $this->enonces = new ArrayCollection();
        $this->formations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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
            $enonce->setChapitre($this);
        }

        return $this;
    }

    public function removeEnonce(Enonce $enonce): static
    {
        if ($this->enonces->removeElement($enonce)) {
            // set the owning side to null (unless already changed)
            if ($enonce->getChapitre() === $this) {
                $enonce->setChapitre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, formations>
     */
    public function getFormations(): Collection
    {
        return $this->formations;
    }

    public function addFormation(formations $formation): static
    {
        if (!$this->formations->contains($formation)) {
            $this->formations->add($formation);
        }

        return $this;
    }

    public function removeFormation(formations $formation): static
    {
        $this->formations->removeElement($formation);

        return $this;
    }

    public function getNomChapitre(): ?string
    {
        return $this->nomChapitre;
    }

    public function setNomChapitre(string $nomChapitre): static
    {
        $this->nomChapitre = $nomChapitre;

        return $this;
    }

    
}
