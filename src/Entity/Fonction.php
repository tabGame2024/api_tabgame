<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\FonctionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FonctionRepository::class)]
#[ApiResource(
    operations:[
        new Get(
            uriTemplate: '/updateUser',
            controller: 'App\Controller\FonctionController::updateUser',
            description: 'Met à jour ou crée un utilisateur.',
            extraProperties: [
                'code' => 'TGV1',
                'function' => 'updateUser',
            ]
        ),
        new Get(
            uriTemplate: '/upload',
            controller: 'App\Controller\FonctionController::upload',
            description: 'Télécharge des fichiers.',
            extraProperties: [
                'code' => 'TGV1',
                'function' => 'upload',
            ]
        ),
        new GetCollection()
    ]
)]
class Fonction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
