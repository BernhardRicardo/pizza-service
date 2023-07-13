<?php

declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Exam21API extends Page
{
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
        $spieler = array();
        $sql = "SELECT *
        FROM `gameDetails`
        INNER JOIN `games` ON `games`.`id` = `gameDetails`.`gameId`
        WHERE `gameDetails`.`gameId` = `games`.`id`";
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
        $total = count($data);
        $serializedData = json_encode($total);
        echo $serializedData;
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
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
