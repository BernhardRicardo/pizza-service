// UpdateStatus.js

var request = new XMLHttpRequest();

function requestData() {
  request.open("GET", "KundenStatus.php");
  request.onreadystatechange = processData;
  request.send(null);
}

function processData() {
  if (request.readyState === XMLHttpRequest.DONE) {
    if (request.status === 200) {
      if (request.responseText !== null) {
        const data = JSON.parse(request.responseText);
        process(data);
      } else {
        console.error('Dokument ist leer');
      }
    } else {
      console.error('Uebertragung fehlgeschlagen');
    }
  }
}

// Function to process the JSON data and insert it into the customer page
function process(jsonData) {
  const statusContainer = document.getElementById("status-container");

  // Clear any existing content in the status container
  while (statusContainer.firstChild) {
    statusContainer.removeChild(statusContainer.firstChild);
  }

  if (jsonData.length === 0) {
    const noPizzaMessage = document.createElement("p");
    noPizzaMessage.textContent = "No pizzas available.";
    statusContainer.appendChild(noPizzaMessage);
    return;
  }

  jsonData.forEach(statusObj => {
    const statusElement = document.createElement("div");
    statusElement.classList.add("status");

    const orderId = document.createElement("p");
    orderId.textContent = "Order ID: " + statusObj.ordering_id;
    statusElement.appendChild(orderId);

    const articleName = document.createElement("p");
    articleName.textContent = "Article Name: " + statusObj.name;
    statusElement.appendChild(articleName);

    for (let i = 0; i < 5; i++) {
      const radio = document.createElement("input");
      radio.type = "radio";
      radio.name = "status";
      radio.value = i;
      statusElement.appendChild(radio);
  
      const label = document.createElement("label");
      label.textContent = i;
      statusElement.appendChild(label);
      // Add spacing between radio buttons
      statusElement.appendChild(document.createTextNode(" "));
  
      // Check the radio button that matches the current status
      if (statusObj.status == i) {
        radio.checked = true;
      }
    }
    statusContainer.appendChild(statusElement);
  });
}

// Start the polling after the page finishes loading
window.onload = function() {
  requestData();
  setInterval(requestData, 2000);
};
