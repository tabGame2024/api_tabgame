<?php

namespace App\Controller;

use App\Dto\EtudiantInput;
use App\Entity\Etudiant;
use App\Entity\Utilisateur;
use App\Repository\EtudiantRepository;
use App\Service\MoodleService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Uuid;
use Symfony\Component\Serializer\SerializerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\JsonResponse;

class EtudiantController extends AbstractController
{
    public function __construct(private EtudiantRepository $etudiants)
    {
    }
    #[Route('/api/etudiants', name: 'all', methods: "GET")]
    public function all(): Response
    {
        $etudiant = $this->etudiants->findAll();
        return $this->json($etudiant);
    }
    #[Route('/api/etudiants/{id}', name: "byId", methods: "GET")]
    public function getById(Uuid $id): Response
    {
        $etudiant = $this->etudiants->findOneBy(["id" => $id]);
        if ($etudiant) {
            return $this->json($etudiant);
        } else {
            return $this->json(["error" => "L\'étudiant n'existe pas:" . $id], 404);
        }
    }

    #[Route('/api/etudiants', name: "createEtudiant", methods: ["POST"])]
    public function createEtudiant(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, LoggerInterface $logger): Response
    {
        $etudiantJson = $request->getContent();
        $logger->info('Received data: ' . $etudiantJson);

        /** @var EtudiantInput $etudiantInput */
        $etudiantInput = $serializer->deserialize($etudiantJson, EtudiantInput::class, 'json');
        $logger->info('Deserialized EtudiantInput: ' . print_r($etudiantInput, true));

        if (is_array($etudiantInput)) {
            $logger->error('Deserialization returned an array instead of an object.');
            return $this->json(['error' => 'Invalid input format'], Response::HTTP_BAD_REQUEST);
        }

        //Verifier le codeId est unique
        if(!$this->isCodeIdUnique($etudiantInput->codeId)){
            return $this->json(['error' => 'le code Id est déjà utilisé.'], Response::HTTP_BAD_REQUEST);
        }

        $etudiant = new Etudiant();
        $etudiant->setNom($etudiantInput->nom);
        $etudiant->setPrenom($etudiantInput->prenom);
        $etudiant->setNomMoodle($etudiantInput->nomMoodle);
        $etudiant->setEmail($etudiantInput->email);
        $etudiant->setCodeId($etudiantInput->codeId);

        $user = $em->getRepository(Utilisateur::class)->find($etudiantInput->users);
        if (!$user) {
            return $this->json(['error' => 'User not found'], Response::HTTP_BAD_REQUEST);
        }

        $etudiant->setUsers($user); // Assignez l'utilisateur trouvé à l'entité Etudiant

        $logger->info('Created Etudiant entity: ' . print_r($etudiant, true));

        $em->persist($etudiant);
        $em->flush();

        return $this->json($etudiant, Response::HTTP_CREATED, [], ['groups' => 'read']);
    }

    private function isCodeIdUnique(string $codeId): bool
    {
        return !$this->etudiants->findOneBy(['codeId' => $codeId]);
    }

    // #[Route('/api/etudiants/check', name:'check_etudiant', methods:['POST'])]
    // public function checkEtudiant(Request $request): Response
    // {
    //     $content = json_decode($request->getContent(), true);
    //     $codeId = $content['codeId'] ?? '';
    //     if ($this->moodleService->checkMoodleUsername($codeId)) {
    //         return $this->json(['status' => 'success'], Response::HTTP_OK);
    //     }

    //     return $this->json(['status' => 'failure', 'message' => 'Username not found in Moodle'], Response::HTTP_NOT_FOUND);
    // }

    // public function index(): Response
    // {
    //     $moodleToken = $_ENV['MOODLE_TOKEN']; // Ou getenv('MOODLE_TOKEN')
    //     return new Response('Moodle Token: ' . $moodleToken);
    // }
}
