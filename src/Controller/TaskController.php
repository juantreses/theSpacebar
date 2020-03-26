<?php

namespace App\Controller;

use PDO;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TaskController extends AbstractController
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = New PDO('mysql:host=localhost;dbname=steden',
            "root",
            "");
    }

    /**
     * @Route("/api/taken")
     */
    public function taken()
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET' :
                $stm = $this->pdo->prepare('SELECT * FROM taak');
                $stm->execute();

                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                return new JsonResponse($rows);
                break;

            case 'POST' :
                $data = json_decode(file_get_contents("php://input"));

                $sql = "INSERT INTO taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr'";

                $stm = $this->pdo->prepare($sql);
                if ($stm->execute()) {
                    return new JsonResponse("Your task was added");
                    break;
                };

        }
    }

    /**
     * @Route("/api/taak/{id}")
     */
    public function taak($id)
    {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET' :
                $stm = $this->pdo->prepare("SELECT * FROM taak WHERE taa_id = $id");
                $stm->execute();

                $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
                return new JsonResponse($rows);
                break;

            case 'PUT' :
                $data = json_decode(file_get_contents("php://input"));

                $sql = "Update taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr' WHERE taa_id = '$id'";

                $stm = $this->pdo->prepare($sql);
                if ($stm->execute()) {
                    return new JsonResponse("Your task was updated");
                    break;
                }

            case 'DELETE' :

                $stm = $this->pdo->prepare("DELETE FROM taak WHERE taa_id = $id");
                if ($stm->execute()) {
                    return new JsonResponse("Your task was deleted");
                }
        }
    }
}
