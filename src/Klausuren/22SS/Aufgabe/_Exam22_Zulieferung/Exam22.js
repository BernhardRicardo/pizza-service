/* Ergänzen Sie hier Ihre JS-Lösung */
let request = new XMLHttpRequest();
function wordClickHandler(){
    'use strict';
    let word;
    //get the word from the clicked element
    if(window.getSelection().toString().length > 1){
    word = window.getSelection().toString();
    //request the explanation
    requestData(word);
    }
    console.log(word);
}


function requestData(Text){
    'use strict';
    //request the result from Exam22API.php
    request.open('GET', 'Exam22API.php?search='+Text);
    request.onreadystatechange = processData;
    request.send(null);

}

function processData(){
    'use strict';
    if(request.readyState === 4){
        if(request.status === 200){
            if(request.responseText != null){
                processExplanation(request.responseText);
            }else{
                console.error('Dokument ist leer');
            }
        }else{
            console.error('Uebertragung fehlgeschlagen');
        }
}
}

function processExplanation(jsonData){
    'use strict';
    let dataObject = JSON.parse(jsonData);
    let ulExplanationsNode = document.getElementById('Definition');
    if(ulExplanationsNode){
        deleteAllChildren(ulExplanationsNode);
        let node = document.createElement('li');
        let textNode = document.createTextNode(dataObject.word + ': ' + dataObject.explanation);
        node.appendChild(textNode);
        ulExplanationsNode.appendChild(node);
    }
}

function deleteAllChildren(node){
    'use strict';
    while(node.firstChild){
        node.removeChild(node.firstChild);
    }
}


