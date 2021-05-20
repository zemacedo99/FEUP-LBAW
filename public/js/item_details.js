let inputQuantity = document.querySelector('#quantity')
let price = document.querySelector('#price')
let add_cart = document.getElementById('add_cart')


inputQuantity.addEventListener("input", changeTotal)

add_cart.addEventListener("click", addCart)

let totalDiv = document.querySelector('#total')

totalDiv.innerHTML = "Total: " + Math.max(0, inputQuantity.value * price.value) + "€"


function changeTotal(event) {

    let totalDiv = document.querySelector('#total')

    totalDiv.innerHTML = "Total: " + Math.max(0, event.target.value * price.value) + "€"
}

function addCart(event){
    let quantity = document.getElementById('quantity').value
    let item_id = document.getElementById('item_id').value
    let client_id = document.getElementById('client_id').value

    if(quantity == "" || quantity < 1){
        document.getElementById("quantity_alert").innerHTML = "Invalid quantity"
        return
    }
    
    if(client_id == "") return;

    sendAjaxRequest('post', '/api/cart', {'item_id':item_id, 'quantity':quantity, 'client_id': client_id}, function(){
        console.log(this.status)
        if(this.status === 201)
            alert("Success")
        else
            alert("Fuck")

    })
    



}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {

    let request = new XMLHttpRequest();

    request.open(method, url, true);
    if (method != 'get') {
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));

}