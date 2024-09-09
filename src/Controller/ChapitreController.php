<?php

namespace App\Controller;

use App\Dto\ChapitreInput;
use App\Entity\Chapitre;
use App\Repository\ChapitreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;

class ChapitreController extends AbstractController
{
    
    public function __construct(private ChapitreRepository $chapitre){

    }
    #[Route('/api/chapitres', name: 'all', methods:"GET")]
    
    public function all(): Response
    {
        $chapitre = $this->chapitre->findAll();
        return $this->json($chapitre);
    }
    #[Route('/api/chapitres/{id}', name:"byId", methods:"GET")]
    public function getById(Uuid $id): Response
    {
        $chapitre = $this->chapitre->findOneBy(["id" => $id]);
        if($chapitre){
            return $this->json($chapitre);
        }else {
            return $this->json(["error" => "Le chapitre n'existe pas:" .$id], 404);
        }
    }

    #[Route('/api/chapitres', name:"create", methods:["POST"])]
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $em,LoggerInterface $logger):Response
    {
        $chapitre = $request->getContent();

        $logger->info('Received data: ' . $chapitre);

        /** @var ChapitreInput $chapitreInput */
        $chapitreInput = $serializer->deserialize($chapitre, ChapitreInput::class, 'json');

        $logger->info('Deserialized ChapitreInput: ' . print_r($chapitreInput, true));

        if (is_array($chapitreInput)) {
            $logger->error('Deserialization returned an array instead of an object.');
            return $this->json(['error' => 'Invalid input format'], Response::HTTP_BAD_REQUEST);
        }

        $chapitre = new Chapitre();
        $chapitre->setNomChapitre($chapitreInput->nomChapitre);

        $logger->info('Created Chapitre entity: ' . print_r($chapitre, true));

        $em->persist($chapitre);
        $em->flush();

        return $this->json($chapitre, Response::HTTP_CREATED, [], ['groups' => 'read']);
        // $entity = Etudiant::create($chapitre->getNom(),$chapitre->getPrenom(), $chapitre->getNomMoodle(), $chapitre->getEmail());
        // $this->etudiants->getEntityManager()->persist($entity);
        // return $this->json([], 201, ["Location" => "/posts/" . $entity->getId()]);
    }
}
