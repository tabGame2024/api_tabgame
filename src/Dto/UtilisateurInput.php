<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class UtilisateurInput
{
    #[Groups(["write"])]
    public ?string $rôles = null;

    #[Groups(["write"])]
    public ?string $email = null;


    // #[Groups(["write"])]
    // public ?int $usersRolesId = null; // Ajoutez cet attribut pour le rôle utilisateur
}
