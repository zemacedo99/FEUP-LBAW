let hasCodeAlready = null
let defaultBorderColor = document.getElementById('coupon_name').style.borderColor

let submit= document.getElementById('form')

submit.addEventListener('submit',validateForm)

function validateForm(event) {

    let couponCode = document.getElementById("code")
    if (couponCode.value === "") {
        couponCode.style.borderColor = "red";
        event.preventDefault()
    }

    sendAjaxRequest('get', 'api/coupon/' + couponCode.value, null, function(){
        console.log(this.status)
        if (this.status === 404) 
            event.preventDefault()
    })

    let check_empty = ['coupon_name', 'coupon_amount', 'coupon_type', 'description', 'date']

    for(let i = 0; i < check_empty.length; i++){
        let input = document.getElementById(check_empty[i]);
        if (input.value === "") {
            input.style.borderColor = "red";
            event.preventDefault()
        }
        input.style.borderColor = defaultBorderColor;
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



    request.open(method, url, true);
    if (method != 'get') {
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));

}