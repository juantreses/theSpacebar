<?php


namespace App\Service;

use PDO;


class DatabaseService
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = New PDO('mysql:host=localhost;dbname=steden',
            "root",
            "");
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
     * @param $sql
     * @return bool
     */
    function executeSQL(string $sql )
    {
        $stm = $this->pdo->prepare($sql);

        if ( $stm->execute() ) return true;
        else return false;
    }

}