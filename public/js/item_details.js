let inputQuantity = document.querySelector('#quantity')
let price = document.querySelector('#price')


inputQuantity.addEventListener("input", changeTotal)


function changeTotal(event) {

    let totalDiv = document.querySelector('#total')

    totalDiv.innerHTML = "Total: " + Number(event.target.value * price.value).toFixed(2);  + "€"
}