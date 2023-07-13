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
        $this->generatePageHeader("Spielplanung");
        //data from the database
        $data = $this->getViewData();
        echo <<<HTML
        <header>
            <img src="Logo.png" >
            <h1>Spielplanung</h1>
        </header> 
        
        <div class="info">
        HTML;
        $specialteam = "kein aktueles Spiel";
        $specialdate ="";
        $teamId;
        $status;
         //make the website html
         for($i=0; $i<count($data); $i++){
            if($data[$i]['status'] == 1 || $data[$i]['status'] == 2){
                $specialdate = htmlspecialchars($data[0]['datetime']);
                $specialteam = htmlspecialchars($data[0]['opposingTeam']);
                $teamId=$data[0]['id'];
                $status=$data[0]['status'];
            }
        }
        echo<<<HTML
            <h2>$specialdate gegen $specialteam</h2>
            <h3>Zusagen Spieler:innen <span id="players">?</span></h3>
            HTML;
            echo <<<HTML
            <form action="Exam21.php" method="post">
            <input type="submit" name="finish" value="Planung abschließen">
            <input type="hidden" name="gameId" value="teamId">
            </form>
        </div>
        <div class="tabel">
        <p>Spiele</p>
        <table>
            <tr>
                <th>Datum</th>
                <th>Team</th>
                <th>Status</th>
            </tr>
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
        }
        echo <<<HTML
        </table>
        HTML;

        $this->generatePageFooter();
    }

    protected function processReceivedData(): void
    {
        parent::processReceivedData();
        //update the game status after submit
        if (isset ($_POST['finish']) && isset($_POST['gameId'])) {
            $gameId = $this->_database->real_escape_string($_POST["gameId"]); 
            $sql = "UPDATE `games` SET status = 2 WHERE `games`.`id` = '$gameId'";
            $this->_database->query($sql);
            header("Location: Exam21.php");
        }

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
