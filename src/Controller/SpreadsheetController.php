<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\SpreadSheet;
use Doctrine\ORM\EntityManagerInterface;

class SpreadsheetController extends AbstractController
{
    /**
     * @Route("/api/upload", name="api_upload", methods={"POST"})
     */
    public function upload(Request $request, EntityManagerInterface $em): Response
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json([
                'error' => 'Invalid JSON: ' . json_last_error_msg()
            ], Response::HTTP_BAD_REQUEST);
        }

        $code = $data['code'] ?? null;
        $function = $data['function'] ?? null;
        $params = $data['params'] ?? [];

        if ($code !== 'TGV1' || $function !== 'upload') {
            return $this->json(['error' => 'Invalid code or function'], Response::HTTP_BAD_REQUEST);
        }

        // Validation des paramètres
        if (count($params) !== 2) {
            return $this->json(['error' => 'Invalid parameters'], Response::HTTP_BAD_REQUEST);
        }

        $nomFichier = $params[0];
        $nomExercice = $params[1];

        // Création d'un nouvel objet SpreadSheet ou mise à jour si déjà existant
        $spreadsheet = new SpreadSheet();
        $spreadsheet->setNomFichier($nomFichier);
        $spreadsheet->setLienFichier('/path/to/storage/' . $nomFichier);

        // Si vous avez un champ pour nomExercice, ajoutez-le ici (par exemple, setNomExercice)

        $em->persist($spreadsheet);
        $em->flush();

        return $this->json([
            'message' => 'Fichier uploadé avec succès',
            'spreadsheet' => [
                'id' => $spreadsheet->getId(),
                'nomFichier' => $spreadsheet->getNomFichier(),
                'lienFichier' => $spreadsheet->getLienFichier(),
            ]
        ]);
    }
}
