/* Ergänzen Sie hier Ihre JS-Lösung */
let request = new XMLHttpRequest();
function wordClickHandler(){
    'use strict';
    //get the word from the clicked element
    let word = window.getSelection().toString();
    request(word);
}

function request(Text){
    'use strict';
    //request the result from Exam22API.php
    request.open('GET', 'Exam22API.php?search='+Text, true);
    request.send();
    request.onreadystatechange = null;
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
        }
}
}

function processExplanation(jsonData){
    'use strict';
    let dataObject = JSON.parse(jsonData);
    addExplanationNode(dataObject.word, dataObject.explanation);
}

function addExplanationNode(word, explanation){
    
    
}