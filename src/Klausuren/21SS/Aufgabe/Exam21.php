<?php

declare(strict_types=1);
// UTF-8 marker äöüÄÖÜß€

require_once './Page.php';

class Exam21 extends Page
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
        $list = array();
        //take ther data from the database
        $sql = "SELECT * FROM `games`";
        $result = $this->_database->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                array_push($list, $row);
            }
        }
        return $list;
    }

    protected function generateView(): void
    {
        //data from the database
        $data = $this->getViewData();
        //make the website html
        //take the first data of the array
        $specialdate = htmlspecialchars($data[0]['datetime']);
        $specialteam = htmlspecialchars($data[0]['opposingTeam']);
        $specialstatus = htmlspecialchars($data[0]['status']);
        echo <<<HTML
        <div class="header">
            <img src="Logo.png" width="200px" height="100px">
            <h1>Spielplanung</h1>
            <form action="Exam21.php" method="post">
        </div> 
        
        <div class="info">
            <h2>$specialdate gegen $specialteam</h2>
            <p>Zusagen Spieler:innen</p>
            <p id="total"></p>
            <button type="submit"">Planung abschließen</button>   
        </div>
        <div class="tabel">
        <p>Spiele</p>
        <table>
            <tr>
                <th>Datum</th>
                <th>Team</th>
                <th>Status</th>
            </tr>
            </form>
        HTML;

        //print the value from the data array
        for ($i = 0; $i < count($data); $i++) {
            $specialdate = htmlspecialchars($data[$i]['datetime']);
            $specialteam = htmlspecialchars($data[$i]['opposingTeam']);
            $specialstatus = htmlspecialchars($data[$i]['status']);
            if ($specialstatus == 0) {
                $specialstatus = "zukünftig";
            } else if ($specialstatus == 1) {
                $specialstatus = "in Planung";
            } else if ($specialstatus == 2) {
                $specialstatus = "abgeschlossen";
            } else {
                $specialstatus = "vorbei";
            }
            echo <<<HTML
            <tr>
                <td>$specialdate</td>
                <td>$specialteam</td>
                <td>$specialstatus</td>
            </tr>
            HTML;

            echo <<<HTML
        </table>
        HTML;
        }
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
    }

    public static function main(): void
    {
        try {
            $page = new Exam21();
            $page->processReceivedData();
            $page->generateView();
        } catch (Exception $e) {
            header("Content-type: text/html; charset=UTF-8");
            echo $e->getMessage();
        }
    }
}


Exam21::main();
