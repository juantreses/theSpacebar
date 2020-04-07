<?php

namespace App\Controller;

use App\Service\DatabaseService;
use PDO;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class TaskController extends AbstractController
{
    private $dbService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->dbService = $databaseService;
    }

    /**
     * @Route("/api/taken", name="api_getTasks", methods={"GET"})
     */
    public function getTaken()
    {
        $rows = $this->dbService->getData('SELECT * FROM taak');

        return new JsonResponse($rows);
    }

    /**
     * @return JsonResponse
     * @Route("/api/taken", name="api_createTasks", methods={"POST"})
     */
    public function createTask()
    {
        $data = json_decode(file_get_contents("php://input"));

        $sql = "INSERT INTO taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr'";

        if ($this->dbService->executeSQL($sql)) {
            $response =  new JsonResponse("Your task was added");
        }
        else {
            $response = new JsonResponse("Something went wrong");
        }

        return $response;
    }

    /**
     * @Route("/api/taak/{id}", name="api_getOneTask", methods={"GET"})
     */
    public function getTaak($id)
    {
        $rows = $this->dbService->getData("SELECT * FROM taak WHERE taa_id = $id");
        return new JsonResponse($rows);
    }

    /**
     * @Route("/api/taak/{id}", name="api_updateTask", methods={"PUT"})
     */
    public function updateTaak($id)
    {
        $data = json_decode(file_get_contents("php://input"));

        $sql = "Update taak SET taa_datum = '$data->taa_datum', taa_omschr = '$data->taa_omschr' WHERE taa_id = '$id'";

        if ($this->dbService->executeSQL($sql)) {
            $response = new JsonResponse("Your task was updated");
        } else {
            $response = new JsonResponse("Something went wrong");
        }

        return $response;
    }

    /**
     * @Route("/api/taak/{id}", name="api_deleteTask", methods={"DELETE"})
     */
    public function deleteTaak($id)
    {
        if ($this->dbService->executeSQL("DELETE FROM taak WHERE taa_id = $id")) {
            $response = new JsonResponse("Your task was deleted");
        }
        else {
            $response = new JsonResponse("Something went wrong");
        }

        return $response;
    }
}
