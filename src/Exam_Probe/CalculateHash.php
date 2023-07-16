<?php

declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class CalculateHash extends Page
{
    private string $myhash;
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
        $data = array();
        return $data;
    }

    protected function generateView(): void
    {
        //print myhash as json
        header("Content-Type: application/json; charset=UTF-8");
        $data = $this->myhash;
        $serializedData = json_encode($data);
        echo $serializedData;
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
        //take the variable url from the link
        if (isset($_GET["URL"])) {
            $url = $_GET["URL"];
            //calculate the hash
            $this->myhash = hash("CRC32", $url);
        } else if (isset($_POST["URL"])) {
            $url = $_POST["URL"];
            //calculate the hash
            $this->myhash = hash("CRC32", $url);
        } else {
            throw new Exception("No URL found!");
        }
    }

    public static function main(): void
    {
        try {
            $page = new CalculateHash();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

CalculateHash::main();
