let request = new XMLHttpRequest();

function process(data){
    //parse the parameter to string
    "use strict";
    console.log(data);
    let dataObject = JSON.parse(data)[0];
    let players = document.getElementById("players");
    players.firstChild.nodeValue = dataObject.playing;
}


function requestData() { // fordert die Daten asynchron an
    "use strict";
    //ToDo - vervollständigen **************
    //request the data
    let gameId = document.getElementById("gameId").value;
    console.log("hallo");
    request.open("GET", "Exam21api.php?gameId="+gameId);
    request.onreadystatechange = processData;
    request.send(null);
}

function processData() {
    "use strict";
    if (request.readyState === 4) { // Uebertragung = DONE
        if (request.status === 200) { // HTTP-Status = OK
            if (request.responseText != null)
            process(request.responseText);
            //ToDo - vervollständigen ************
            else console.error("Dokument ist leer");
        } else console.error("Uebertragung fehlgeschlagen");
    } // else; // Uebertragung laeuft noch
}

function pollData() {
    "use strict";
    requestData();
    window.setInterval(requestData, 5000);
}
window.setInterval(console.log("hallo"), 5000);