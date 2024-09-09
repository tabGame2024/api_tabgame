<?php
// src/Service/FonctionService.php

namespace App\Service;

use App\Entity\Fonction;
use App\Repository\FonctionRepository;
use Doctrine\ORM\EntityManagerInterface;


class FonctionService
{
    // Exemple de dépendances si nécessaires, comme des repositories
    // private $userRepository;
    // private $fileRepository;

    // public function __construct(UserRepository $userRepository, FileRepository $fileRepository)
    // {
    //     $this->userRepository = $userRepository;
    //     $this->fileRepository = $fileRepository;
    // }
    private $fonctionRepository;
    private $entityManager;

    public function __construct(FonctionRepository $fonctionRepository, EntityManagerInterface $entityManager)
    {
        $this->fonctionRepository = $fonctionRepository;
        $this->entityManager = $entityManager;
    }

    public function updateUser(string $params): array
    {
        // Logique pour mettre à jour ou créer un utilisateur dans la base de données
        $fonction = $this->fonctionRepository->findOneBy(['name' => $params]);

        if (!$fonction) {
            // Création d'une nouvelle entrée si elle n'existe pas
            $fonction = new Fonction();
            $fonction->setName($params);
            $this->entityManager->persist($fonction);
            $this->entityManager->flush();

            return ['status' => 'created', 'id' => $fonction->getId()];
        }

        // Mise à jour de l'entrée existante (par exemple, en mettant à jour la dernière connexion)
        // Ajoutez ici la logique spécifique pour mettre à jour les données

        return ['status' => 'updated', 'id' => $fonction->getId()];
    }

    public function uploadFiles(array $fileList): array
    {
        // Logique pour télécharger des fichiers
        // Cette fonction est un exemple ; vous devez adapter la logique en fonction de vos besoins

        return ['status' => 'success', 'files' => $fileList];
    }

}
