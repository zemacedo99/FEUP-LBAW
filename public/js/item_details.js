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
            var myModal = new bootstrap.Modal(document.getElementById('success_add_cart'), null)
            myModal.show()
    })
    
}
