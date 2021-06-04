let hasCodeAlready = null


let submit= document.getElementById('form')

submit.addEventListener('submit',validateForm)

function validateForm(event) {
    try{

        let check_empty = ['bundle_name', 'bundle_price' , 'bundle_stock', 'description']

        for(let i = 0; i < check_empty.length; i++){
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
                event.preventDefault()
            }

        }
        
    }catch(err){
        //alert(err.message)
        event.preventDefault()
    }
}

function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler) {

    let request = new XMLHttpRequest();

    request.open(method, url, false);
    if (method != 'get') {
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));

}

let card_prods = document.querySelectorAll('.prod_ovrw')
for(let i = 0; i < card_prods.length; i++){
    card_prods[i].addEventListener('click', addProduct)
}

function addProduct(event){
    let searchNode = event.target.parentNode.parentNode.parentNode.parentNode.parentNode.parentNode
    let name = searchNode.querySelector('.name').value
    let image = searchNode.querySelector('.imgProd').value

    addToCardDiv(name, image)
}

function addToCardDiv(name, image){
    document.getElementById('divCardProds').innerHTML += `
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="${image}" class="img-fluid" alt="${name}" style="max-height: 200px">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title">${name}</h5>
                    <p class="card-text">Total: 1</p>
                    <span>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-plus-circle"></i></button>
                        <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-dash-circle"></i></button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    `
}