<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\SpreadSheetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\SpreadsheetController;

#[ORM\Entity(repositoryClass: SpreadSheetRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(),
        new Post(
            uriTemplate: '/spreadsheet/upload',
            controller: SpreadsheetController::class . '::upload',
            openapiContext: [
                'summary' => 'Upload a new spreadsheet',
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'code' => ['type' => 'string'],
                                    'function' => ['type' => 'string'],
                                    'params' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string'
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'responses' => [
                    '200' => [
                        'description' => 'Fichier uploadé avec succès',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => ['type' => 'string'],
                                        'spreadsheet' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'id' => ['type' => 'integer'],
                                                'nomFichier' => ['type' => 'string'],
                                                'lienFichier' => ['type' => 'string'],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ),
    ]
)]
class SpreadSheet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Enonce::class, mappedBy: 'spreadsheet')]
    private Collection $enonces;

    #[ORM\OneToMany(targetEntity: Devoir::class, mappedBy: 'spreadsheet')]
    private Collection $devoirs;

    #[ORM\OneToMany(targetEntity: rendu::class, mappedBy: 'spreadSheet')]
    private Collection $rendus;

    #[ORM\Column(length: 255)]
    private ?string $nomFichier = null;

    #[ORM\Column(length: 255)]
    private ?string $lienFichier = null;

    public function __construct()
    {
        $this->enonces = new ArrayCollection();
        $this->devoirs = new ArrayCollection();
        $this->rendus = new ArrayCollection();
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
            $enonce->setSpreadsheet($this);
        }

        return $this;
    }

    public function removeEnonce(Enonce $enonce): static
    {
        if ($this->enonces->removeElement($enonce)) {
            // set the owning side to null (unless already changed)
            if ($enonce->getSpreadsheet() === $this) {
                $enonce->setSpreadsheet(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Devoir>
     */
    public function getDevoirs(): Collection
    {
        return $this->devoirs;
    }

    public function addDevoir(Devoir $devoir): static
    {
        if (!$this->devoirs->contains($devoir)) {
            $this->devoirs->add($devoir);
            $devoir->setSpreadsheet($this);
        }

        return $this;
    }

    public function removeDevoir(Devoir $devoir): static
    {
        if ($this->devoirs->removeElement($devoir)) {
            // set the owning side to null (unless already changed)
            if ($devoir->getSpreadsheet() === $this) {
                $devoir->setSpreadsheet(null);
            }
        }

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
            $rendu->setSpreadSheet($this);
        }

        return $this;
    }

    public function removeRendu(rendu $rendu): static
    {
        if ($this->rendus->removeElement($rendu)) {
            // set the owning side to null (unless already changed)
            if ($rendu->getSpreadSheet() === $this) {
                $rendu->setSpreadSheet(null);
            }
        }

        return $this;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): static
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getLienFichier(): ?string
    {
        return $this->lienFichier;
    }

    public function setLienFichier(string $lienFichier): static
    {
        $this->lienFichier = $lienFichier;

        return $this;
    }
}
