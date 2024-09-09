<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UtilisateurController extends AbstractController
{
    public function __construct(private UtilisateurRepository $utilisateur, private EntityManagerInterface $em) {}
    #[Route('/api/utilisateurs', name: 'all', methods: "GET")]
    public function all(): Response
    {
        $utilisateur = $this->utilisateur->findAll();
        return $this->json($utilisateur);
    }
    // #[Route('/api/utilisateurs/{id}', name:'id_user', methods:"GET")]
    // public function idUser():Response
    // {

    // }
    // #[Route('/api/utilisateurs/update', name:'update_user', methods: ['POST'])]
    // public function UpdateUser(Request $request): Response
    // {
    //     $data = json_decode($request->getContent(), true);

    //     if (json_last_error() !== JSON_ERROR_NONE) {
    //         return $this->json([
    //             'error' => 'Invalid JSON: ' . json_last_error_msg()
    //         ], Response::HTTP_BAD_REQUEST);
    //     }
    //     $code = $data['code'] ?? null;
    //     $function = $data['function'] ?? null;
    //     $params = $data['params'] ?? null;

    //     //  Ajoutez ces lignes pour déboguer
    //     error_log("Code: " . print_r($code, true));
    //     error_log("Function: " . print_r($function, true));
    //     error_log("Params: " . print_r($params, true));

    //     if ($code !== 'TGV1' || $function !== 'updateUser') {
    //         return $this->json(['error' => 'Invalid code or function'], Response::HTTP_BAD_REQUEST);
    //     }
    //     $email = $params['email'] ?? null;
    //     $roles = $params['roles'] ?? ['ROLE_USER'];

    //     if (!$email) {
    //         return $this->json(['error' => 'Email is required'], Response::HTTP_BAD_REQUEST);
    //     }

    //     $utilisateur = $this->utilisateur->findOneBy(['email' => $email]);

    //     if ($utilisateur) {
    //         // Update the last access date
    //         $utilisateur->setLastAccess(new \DateTime());
    //     } else {
    //         // Create a new user
    //         $utilisateur = new Utilisateur();
    //         $utilisateur->setEmail($email);
    //         $utilisateur->setRoles($roles);
    //         $utilisateur->setPassword(''); // You might want to set a default or hashed password
    //         $utilisateur->setLastAccess(new \DateTime());

    //         $this->em->persist($utilisateur);
    //     }

    //     $this->em->flush();

    //     return $this->json([
    //         'message' => 'Utilisateur mis à jour avec succès',
    //         'utilisateur' => $utilisateur
    //     ]);
    // }


    // #[Route('/api/utilisateurs/update', name: 'update_user', methods: ['POST'])]
    public function updateUser(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'error' => 'Invalid JSON: ' . json_last_error_msg()
            ], Response::HTTP_BAD_REQUEST);
        }

        $code = $data['code'] ?? null;
        $function = $data['function'] ?? null;
        $params = $data['params'] ?? null;

        // Debugging logs
        error_log("Code: " . print_r($code, true));
        error_log("Function: " . print_r($function, true));
        error_log("Params: " . print_r($params, true));

        if ($code !== 'TGV1' || $function !== 'updateUser') {
            return $this->json(['error' => 'Invalid code or function'], Response::HTTP_BAD_REQUEST);
        }

        // Extract email and role from params
        $email = $params['email'] ?? null;
        $role = $params['role'] ?? 'ROLE_USER'; // Default role

        if (!$email) {
            return $this->json(['error' => 'Email is required'], Response::HTTP_BAD_REQUEST);
        }

        // Determine role based on params if role is provided as a string
        if (is_string($role)) {
            switch ($role) {
                case 'student':
                    $role = 'ROLE_STUDENT';
                    break;
                case 'editor':
                    $role = 'ROLE_EDITOR';
                    break;
                default:
                    $role = 'ROLE_USER';
            }
        }

        $utilisateur = $this->utilisateur->findOneBy(['email' => $email]);

        if ($utilisateur) {
            // Update last access and role
            $utilisateur->setLastAccess(new \DateTime());
            $roles = $utilisateur->getRoles();
            if (!in_array($role, $roles)) {
                $roles[] = $role;
                $utilisateur->setRoles($roles);
            }
        } else {
            // Create new user
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($email);
            $utilisateur->setRoles([$role]);
            $utilisateur->setPassword(''); // Default or hashed password
            $utilisateur->setLastAccess(new \DateTime());

            $this->em->persist($utilisateur);
        }

        $this->em->flush();

        return $this->json([
            'message' => 'Vous êtes inscrite au cours',
            'utilisateur' => $utilisateur
        ]);
    }
}
