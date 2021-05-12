let plus = document.getElementsByClassName('plusQuantity')
let minus = document.getElementsByClassName('minusQuantity')
let periodic = document.getElementsByClassName('periodic')
let addCouponBtn = document.getElementById('addCoupon')

for(let i = 0; i < plus.length; i++){
    plus[i].addEventListener('click', addQuantity)
}

for(let i = 0; i < minus.length; i++){
    minus[i].addEventListener('click', removeQuantity)
}

for(let i = 0; i < periodic.length; i++){
    periodic[i].addEventListener('click', updatePeriodic)
}

addCouponBtn.addEventListener('click', addCoupon)



function addQuantity(event){
    
    let btn = event.target
    let display = btn.parentNode.parentNode.childNodes[1].childNodes[1]
    let input = btn.parentNode.parentNode.childNodes[1].childNodes[3];
    let nr = input.id.split('_')[1]
    
    let previousQuantity = display.innerHTML.split(' ')[1]
     
    display.innerHTML = "Total: " + (parseInt(previousQuantity) + 1)
    input.value = parseInt(input.value) + 1

    updatePrice(parseFloat(document.getElementById('price_' + nr).value))

}

function removeQuantity(event){
    
    let btn = event.target
    let display = btn.parentNode.parentNode.childNodes[1].childNodes[1]
    let input = btn.parentNode.parentNode.childNodes[1].childNodes[3];
    let nr = input.id.split('_')[1]

    let previousQuantity = parseInt(display.innerHTML.split(' ')[1])

    display.innerHTML = "Total: " + Math.max(previousQuantity - 1, 0)
    input.value = Math.max((parseInt(input.value) - 1), 0)

    if(previousQuantity !== 0)
        updatePrice(-parseFloat(document.getElementById('price_' + nr).value))
}

function updatePrice(price){
    let totalPrice = document.getElementById('total_price')

    totalPrice.innerHTML = 'Total: ' + (parseFloat(totalPrice.innerHTML.split(' ')[1]) + price).toFixed(2) + '€'
}

function updatePeriodic(event){
    let periodicInput = document.getElementById('periodic')
    console.log(event.target)
    periodicInput.value = event.target.getAttribute('name')
}

function addCoupon(event){
    let couponCode = document.getElementById('coupon_code')

    sendAjaxRequest('get', '/api/coupon/' + couponCode.value, null, function(){
        if (this.status === 404){
            document.getElementById("coupon_alert").innerHTML = "There are no coupons with that code"
            
        }else{
            let couponsList = document.getElementById('coupons_list')
            let coupon = JSON.parse(this.responseText);
            couponsList.innerHTML += createCouponCard(coupon[0])
        }
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

function createCouponCard(coupon){
    return `
    <div class="col-lg-4 col-10 mx-auto">
        <div class="p-3">
            <div class="card">

                <div class="col">
                    <img src="{{asset('storage/images/otap071yo9zJOzlhOLXJsgtvxAmlG0D5SkwfJzOJ.jpg')}}" class="img-fluid" alt="cupon" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
                </div>


                <div class="card-img-overlay">
                    <div class="text-center">
                        <br><br>
                        <h5 class="card-title">${coupon.name}</h5>
                        <p class="card-text">${coupon.amount}${coupon.type}</p>
                    </div>
                </div>

                <div class="card-footer">
                    <small class="text-muted">Valid until ${coupon.expiration}</small>
                </div>


            </div>
        </div>
    </div>
`
}


