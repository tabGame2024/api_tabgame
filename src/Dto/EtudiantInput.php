<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class EtudiantInput
{
    #[Groups(["write"])]
    public ?string $nom = null;

    #[Groups(["write"])]
    public ?string $prenom = null;

    #[Groups(["write"])]
    public ?string $nomMoodle = null;

    #[Groups(["write"])]
    public ?string $email = null;


    #[Groups(["write"])]
    public ?int $users = null;

    #[Groups(["write"])]
    public ?int $codeId = null;

    // #[Groups(["write"])]
    // public ?int $usersRolesId = null; // Ajoutez cet attribut pour le rôle utilisateur
}
