<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Dto\EtudiantInput;
use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use GuzzleHttp\Psr7\Message;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ApiResource(
    // operations:[
    //     'get'=>[]
    // ],
    // operations: [
    //     'post' => [
    //         'input_formats' => [
    //             'json' => ['application/json'],
    //             'jsonld' => ['application/ld+json'],
    //         ],
    //     ],
    //     'get' => [
    //         'normalization_context' => ['groups' => ['read']],
    //     ],
    // ],
    // itemOperations: [
    //     'get' => [
    //         'normalization_context' => ['groups' => ['read']],
    //     ],
    //     'put' => [
    //         'denormalization_context' => ['groups' => ['write']],
    //     ],
    //     'delete' => [],
    // ],
    openapiContext:[
        'description' => 'les étudiants',
        'type' => 'int',
        'exemple' => '1'
    ],
    // transformer en tableau
    normalizationContext:["groups"=> ["read"]],
    // transformer en json
    denormalizationContext:["groups"=>["write"]],
    // input: EtudiantInput::class
)]
class Etudiant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read"])]
    private ?int $id = null;


    #[ORM\ManyToOne(inversedBy: 'etudiants')]
    #[ORM\JoinColumn(nullable: false)]

    #[Groups(["write"])]
    private ?utilisateur $users = null;

   

    #[ORM\OneToMany(targetEntity: devoir::class, mappedBy: 'etudiant')]

    #[Ignore]
    private Collection $devoir;

    #[ORM\Column(length: 255)]
    #[Groups(["read", "write"])]


    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read", "write"])]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read", "write"])]
    private ?string $nomMoodle = null;

    #[ORM\Column(length: 255)]
    #[Groups(["read", "write"])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"le nom d'utilisateur ne doit pas être vide")]
    #[Assert\Regex(
        pattern: '/^[a-zA-Z0-9]+$/',
        message:"Le nom d'utilisateur doit comporter des chiffres et lettres"
    )]
    #[Groups(["read", "write"])]
    private ?string $codeId = null;

    public function __construct()
    {
        $this->devoir = new ArrayCollection();
    }

 
    public function getId(): ?int
    {
        return $this->id;
    }


    public function getUsers(): ?utilisateur
    {
        return $this->users;
    }

    public function setUsers(?utilisateur $users): static
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return Collection<int, devoir>
     */
    public function getDevoir(): Collection
    {
        return $this->devoir;
    }

    public function addDevoir(devoir $devoir): static
    {
        if (!$this->devoir->contains($devoir)) {
            $this->devoir->add($devoir);
            $devoir->setEtudiant($this);
        }

        return $this;
    }

    public function removeDevoir(devoir $devoir): static
    {
        if ($this->devoir->removeElement($devoir)) {
            // set the owning side to null (unless already changed)
            if ($devoir->getEtudiant() === $this) {
                $devoir->setEtudiant(null);
            }
        }

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNomMoodle(): ?string
    {
        return $this->nomMoodle;
    }

    public function setNomMoodle(string $nomMoodle): static
    {
        $this->nomMoodle = $nomMoodle;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCodeId(): ?string
    {
        return $this->codeId;
    }

    public function setCodeId(string $codeId): static
    {
        $this->codeId = $codeId;

        return $this;
    }



}
