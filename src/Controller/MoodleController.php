<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoodleController extends AbstractController
{
    /**
     * @Route("/fetch-page", name="fetch_page")
     */
    public function fetchPage(Request $request): Response
    {
        // Récupérer le token depuis la requête
        $token = $request->query->get('token');

        if (!$token) {
            return new Response('Token is missing', 400);
        }

        // Utiliser le token pour obtenir les informations de l'utilisateur depuis Moodle
        $userInfo = $this->getMoodleUserInfo($token);
        if (!isset($userInfo['users'][0]['username'])) {
            return new Response('User not found or invalid token', 404);
        }
        $username = $userInfo['users'][0]['username'];
        $url = 'https://upjv.info/tgpage.php?user=' . urlencode($username);
        $content = $this->fetchPageContent($url);

        return new Response($content);
    }

    private function fetchPageContent($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Désactiver la vérification du certificat SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // Désactiver la vérification de l'hôte SSL

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        return $response;
    }

    private function getMoodleUserInfo($token)
    {
        $domainName = 'http://localhost/moodle';
        $functionName = 'core_user_get_users';
        $restFormat = 'json';

        $criteria = [
            ['key' => 'id', 'value' => 2] // Changez 2 par l'id de l'utilisateur Moodle si nécessaire
        ];

        $serverUrl = $domainName . '/webservice/rest/server.php?wstoken=' . $token . '&wsfunction=' . $functionName . '&moodlewsrestformat=' . $restFormat;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $serverUrl . '&criteria[0][key]=' . urlencode($criteria[0]['key']) . '&criteria[0][value]=' . urlencode($criteria[0]['value']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new \Exception('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
