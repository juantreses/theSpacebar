<?php

namespace App\Controller;

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
    private $pdo;

    public function __construct()
    {
        $this->pdo = New PDO('mysql:host=localhost;dbname=steden',
            "root",
            "Wh3nP7agu35");
    }

    /**
     * @param string $sql
     * @return mixed
     */
    public function getData($sql)
    {
        $stm = $this->pdo->prepare($sql);
        $stm->execute();

        $rows = $stm->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    /**
     * @Route("/steden", name="app_citiespage")
     */
    public function citiespage()
    {
       $cities = $this->getData("SELECT * FROM images");

        return $this->render('city/cities.html.twig', [
            'data' => $cities
        ]);
    }

    /**
     * @Route("/stad/{id}")
     */
    public function citypage($id)
    {
        $city = $this->getData("SELECT * FROM images WHERE img_id = $id");


        return $this->render('city/city.html.twig', [
            'data' => $city[0]
        ]);
    }
}