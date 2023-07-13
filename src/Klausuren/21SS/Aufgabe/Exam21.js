let request = new XMLHttpRequest();

function process(string){
    //parse the parameter to string
    const data = JSON.parse(string);
    //print it to html total
    document.getElementById("total").textContent = data;

}


function requestData() { // fordert die Daten asynchron an
    "use strict";
    //ToDo - vervollständigen **************
    //take total from Exam21API.php
    request.open("GET", "Exam21API.php", true);
    request.onreadystatechange = processData;
    request.send(null);
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
            process(request.responseText)
               ;//ToDo - vervollständigen ************
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

