let hasCodeAlready = null
let defaultBorderColor = document.getElementById('coupon_name').style.borderColor

function validateForm() {

    let couponCode = document.getElementById("code")
    if (couponCode.value === "") {
        couponCode.style.borderColor = "red";
        return false;
    }
    sendAjaxRequest('get', 'api/coupon/' + couponCode.value, null, codeHandler)

    let check_empty = ['coupon_name', 'coupon_price', 'coupon_type', 'Description', 'date']

    for(let i = 0; i < check_empty.length; i++){
        let input = document.getElementById(check_empty[i]);
        if (input.value === "") {
            input.style.borderColor = "red";
            return false
        }
        input.style.borderColor = defaultBorderColor;
    }

   
    let i = 0;
    while (hasCodeAlready === null && i < 1000)
        i = i + 1

    if (i >= 1000)
        return false

    return !hasCodeAlready;
}

function codeHandler() {
    if (this.status === 404) {
        hasCodeAlready = false
    } else if (this.status === 200) {
        hasCodeAlready = true
    }
    return true;
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