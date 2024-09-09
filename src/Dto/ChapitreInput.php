<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

class ChapitreInput
{
    

    #[Groups(["write"])]
    public ?string $nomChapitre = null;

   

   
}
