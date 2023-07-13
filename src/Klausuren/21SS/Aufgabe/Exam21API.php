<?php

declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Exam21API extends Page
{
    private int $gameId = -1;
    protected function __construct()
    {
        parent::__construct();
    }

    public function __destruct()
    {
        parent::__destruct();
    }

    protected function getViewData(): array
    {
        //check if gameid is existing
        $spieler = array();
        $sql = "SELECT count(*) AS playing FROM gameDetails WHERE gameId = $this->gameId";
        $result = $this->_database->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($spieler, $row);
            }
        }
        return $spieler;
    }

    protected function generateView(): void
    {
        header("Content-Type: application/json; charset=UTF-8");
        $data = $this->getViewData();
        $serializedData = json_encode($data);
        echo $serializedData;
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
        if (isset($_GET["gameId"]) && is_numeric($_GET["gameId"])) {
            $this->gameId = (int) $_GET["gameId"];
        }
        
    }

    public static function main(): void
    {
        try {
            $page = new Exam21API();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

Exam21API::main();
