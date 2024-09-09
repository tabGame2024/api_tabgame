<?php

namespace App\Service;

use App\Entity\Etudiant;
use App\Repository\EtudiantRepository;
use Doctrine\ORM\EntityManagerInterface;

class EtudiantService
{
    private EtudiantRepository $etudiantRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(EtudiantRepository $etudiantRepository, EntityManagerInterface $entityManager)
    {
        $this->etudiantRepository = $etudiantRepository;
        $this->entityManager = $entityManager;
    }

    public function saveEtudiant(Etudiant $etudiant): Etudiant
    {
        if ($this->isCodeIdUnique($etudiant->getCodeId())) {
            // Enregistrez l'étudiant si le codeId est unique
            $this->entityManager->persist($etudiant);
            $this->entityManager->flush();
        } else {
            throw new \Exception("Le code ID est déjà utilisé.");
        }

        return $etudiant;
    }

    private function isCodeIdUnique(string $codeId): bool
    {
        return !$this->etudiantRepository->findOneBy(['codeId' => $codeId]);
    }

    public function findAll(): array
    {
        return $this->etudiantRepository->findAll();
    }

    public function findById(string $id): ?Etudiant
    {
        return $this->etudiantRepository->find($id);
    }
}
