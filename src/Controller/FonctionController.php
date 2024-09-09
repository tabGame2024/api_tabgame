<?php

namespace App\Controller;

// use GuzzleHttp\Psr7\Request;

use App\Service\FonctionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FonctionController extends AbstractController
{
    private $fonctionService;
public function __construct(FonctionService $fonctionService)
{
    $this->fonctionService = $fonctionService;
}

    #[Route('/api/fonction', name: 'app_fonction')]
    public function index(): Response
    {
        return $this->render('fonction/index.html.twig', [
            'controller_name' => 'FonctionController',
        ]);
    }
    #[Route('/api/updateUser', name: 'update_user', methods: ['GET'])]
    public function updateUser(Request $request): JsonResponse
    {
        $code = $request->query->get('code');
        $function = $request->query->get('function');
        $params = $request->query->get('params');

        if ($code === 'TGV1' && $function === 'updateUser' && $params === 'student') {
            $result = $this->fonctionService->updateUser($params);
            return new JsonResponse(['message' => 'Vous êtes inscrit au cours', 'result' => $result], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Invalid request'], JsonResponse::HTTP_BAD_REQUEST);
    }

    #[Route('/api/upload', name: 'upload_file', methods: ['GET'])]
    public function upload(Request $request): JsonResponse
    {
        $code = $request->query->get('code');
        $function = $request->query->get('function');
        $params = $request->query->get('params');

        if ($code === 'TGV1' && $function === 'upload') {
            $fileList = explode(',', $params);
            $result = $this->fonctionService->uploadFiles($fileList);
            return new JsonResponse(['message' => 'Fichiers téléchargés', 'result' => $result], JsonResponse::HTTP_OK);
        }

        return new JsonResponse(['error' => 'Invalid request'], JsonResponse::HTTP_BAD_REQUEST);
    }
}
