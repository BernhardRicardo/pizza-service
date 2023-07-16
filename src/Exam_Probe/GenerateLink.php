<?php

declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€
require_once './Page.php';

class GenerateLink extends Page
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
        $data = array();
        return $data;
    }

    protected function generateView(): void
    {
        $this->generatePageHeader('H-DA Link Shortner!');
        echo <<<HTML
        <body>
        <div class="navbar">
            <a href="">Home</a>
            <a href="">Products</a>
            <a href="">Company</a>
            <a href="">Blog</a>
        </div>
        HTML;

        echo <<<HTML
        <form action="GenerateLink.php" method="post">
        <section class="input">
         <h1>Link Shortner!</h1>
         <input type="text" id="URL" name="URL" placeholder="Enter Link" onkeyup="processData(event); requestData();">
         <input type="submit" id="submit" value="submit">
         <input type="hidden" id="hiddenhash" name="hiddenhash" value="">
        </section>
        </form>
        <section class="output">
            <h1>Send an URL and we shorten it for you!</h1>
            <fieldset>
                <p id="shortlink" name="shortlink"></p>
            </fieldset>
        </section>
        HTML;

        echo <<<HTML
        <div class="footer">
            <h1>H_DA EWA 2021</h1>
        </div>
        </body>
        HTML;


        $this->generatePageFooter();
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
        //put the URL and the hash in the database
        if (isset($_POST["URL"]) && isset($_POST["hiddenhash"])) {
            $url = $_POST["URL"];
            $escapedURL = $this->_database->real_escape_string($url);
            //get the hash value from the CalculateHash.php
            $shortlink = $_POST["hiddenhash"];
            $escapedlink = $this->_database->real_escape_string($shortlink);

            //check if url and hash already existed
            $sql = "SELECT * FROM hash2URL WHERE hash = '$escapedlink' AND URL = '$escapedURL'";
            $recordset = $this->_database->query($sql);
            if (!$recordset)
                throw new Exception("Fehler in Abfrage: " . $this->_database->error);
            if ($recordset->num_rows == 0) {
                //insert the url and hash in the database
                $sql = "INSERT INTO hash2URL (hash, URL) VALUES ('$escapedlink', '$escapedURL')";
                $recordset = $this->_database->query($sql);
                if (!$recordset)
                    throw new Exception("Fehler in Abfrage: " . $this->_database->error);
            }
            // Weiterleitung nach PRG-Pattern
            header("HTTP/1.1 303 See Other");
            header("Location: " . "GenerateLink.php");
            die(); // hier ausnahmsweise ok !
        }
    }
    public static function main(): void
    {
        try {
            $page = new GenerateLink();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/plain; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}

GenerateLink::main();
