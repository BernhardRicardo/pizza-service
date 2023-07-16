let request = new XMLHttpRequest();

function requestData() { // fordert die Daten asynchron an
    "use strict";
    //request the calculate hash from CalculateHash.php
    var text = document.getElementById("URL").value;
    request.open("GET", "CalculateHash.php?URL=" + text, true);
    request.onreadystatechange = processData;
    request.send(null);

}

function processData(event) {
    event.preventDefault();
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null){
                //ToDo - vervollständigen ************
                process(request.responseText)
            }
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

function process(url){
    "use strict";
    console.log(url);
    var data = JSON.parse(url);
    var result = document.getElementById("shortlink");
    result.textContent = "Hash:" + data;
    var hidden = document.getElementById("hiddenhash");
    hidden.value = data;
}