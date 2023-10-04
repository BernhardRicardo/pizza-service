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

  //Make h1 for kunde string
  const kunde = document.createElement("h1");
  kunde.textContent = "Customer";
  statusContainer.appendChild(kunde);

  //Make hr
  const hr = document.createElement("hr");
  statusContainer.appendChild(hr);

  //Make paragraph for order id
  const orderId = document.createElement("p");
  orderId.textContent = "Order ID: "+jsonData[0].ordering_id;
  orderId.classList.add("orderId");
  statusContainer.appendChild(orderId);
  //Style order id
  const orderStatus = document.getElementsByClassName("orderId");
  orderStatus[0].setAttribute("class", "order-id")


  jsonData.forEach(statusObj => {
    //Make fieldset
    const fieldset = document.createElement('fieldset');

    const statusElement = document.createElement("div");
    statusElement.classList.add("status");



    const articleName = document.createElement("p");
    articleName.textContent = "Pizza: " + statusObj.name;
    statusElement.appendChild(articleName);

    for (let i = 0; i < 5; i++) {
      const radio = document.createElement("input");
      radio.type = "radio";
      radio.name = "status_"+statusObj.ordered_article_id;
      radio.value = i;
      statusElement.appendChild(radio);
  
      const label = document.createElement("label");
      if(i== 0) {
      label.textContent = "Ordered";
      } else if(i == 1) {
        label.textContent = "In oven";
      } else if(i == 2) {
        label.textContent = "Ready to deliver";
      } else if(i == 3) {
        label.textContent = "On the way";
      } else if(i == 4) {
        label.textContent = "Delivered";
      }
      statusElement.appendChild(label);
      // Add spacing between radio buttons
      statusElement.appendChild(document.createTextNode(" "));
  
      // Check the radio button that matches the current status
      if (statusObj.status == i) {
        radio.checked = true;
      }
    }
    // Append the status element to the fieldset
    fieldset.appendChild(statusElement);
    
    statusContainer.appendChild(fieldset);
  });
}

// Start the polling after the page finishes loading
window.onload = function() {
  requestData();
  setInterval(requestData, 2000);
};
