let inputQuantity = document.querySelector('#quantity')
let price = document.querySelector('#price')

inputQuantity.addEventListener("input", changeTotal)

function changeTotal(event) {

    let totalDiv = document.querySelector('#total')

    totalDiv.innerHTML = "Total: " + event.target.value * price.value + "€"
}
