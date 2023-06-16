//add to cart
function addToCart(name,price,value){
    "use strict";
    var cart = document.getElementById("cart");
    var item = document.createElement("option");
    item.value = value;
    item.name = name;
    item.price = price;
    item.textContent = name;
    cart.appendChild(item);
    countTotalPrice();
}

//remove from cart
function removeFromCart(){
    "use strict";
    var cart = document.getElementById("cart");
    var selected = findAllSelected();

    //remove all selected items using for each
    selected.forEach(function(item){
        cart.removeChild(item);
    }
    );
    countTotalPrice();
}

function findAllSelected(){
    "use strict";
    var cart = document.getElementById("cart");
    var selected = [];
    for(var i = 0; i < cart.length; i++){
        if(cart.options[i].selected){
            selected.push(cart.options[i]);
        }
    }
    return selected;
}

//count total price
function countTotalPrice() {
    "use strict";
    var totalElement = document.getElementById("total");
    totalElement.textContent = "";
  
    var cart = document.getElementById("cart");
    var total = Number("0.00");
  
    for (var i = 0; i < cart.length; i++) {
      total += parseFloat(Number(cart.options[i].price));
    }
  
    console.log(total);
    totalElement.textContent = "Price: $" + total.toFixed(2).toString();
  }
  

//clear cart
function clearCart(){
    "use strict";
    var cart = document.getElementById("cart");
    cart.textContent = "";
    countTotalPrice();
    checkInputs();
}

//select all item in cart
function selectAll(){
    "use strict";
    var cart = document.getElementById("cart");
    for(var i = 0; i < cart.length; i++){
        cart.options[i].selected = true;
    }
}

function checkInputs(){
    "use strict";
    var cart = document.getElementById("cart");
    var cartValue = cart.options.value;
    var addressValue = document.getElementById("inputAddress").value;
    var btnSubmit = document.getElementById("btnSubmit");

    if((cartValue == "" && cart.length > 1) || addressValue == ""){
        btnSubmit.disabled = true;
    }else{
        btnSubmit.disabled = false;
    }
}