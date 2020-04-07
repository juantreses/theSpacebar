<?php

namespace App\Controller;

use App\Service\DatabaseService;
use Michelf\MarkdownInterface;
use PDO;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class CityController extends AbstractController
{
    private $dbService;

    public function __construct(DatabaseService $dbService)
    {
        $this->dbService = $dbService;
    }

    /**
     * @Route("/steden", name="app_citiespage")
     */
    public function citiespage()
    {
       $cities = $this->dbService->getData("SELECT * FROM images");

        return $this->render('city/cities.html.twig', [
            'data' => $cities
        ]);
    }

    /**
     * @Route("/stad/{id}")
     */
    public function citypage($id, DatabaseService $databaseService)
    {
        $city = $this->dbService->getData("SELECT * FROM images WHERE img_id = $id");


        return $this->render('city/city.html.twig', [
            'data' => $city[0]
        ]);
    }
}