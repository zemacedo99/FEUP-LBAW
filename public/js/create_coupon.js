let hasCodeAlready = null


let submit= document.getElementById('form')

submit.addEventListener('submit',validateForm)

function validateForm(event) {
    try{
        let couponCode = document.getElementById("code")
        if (couponCode.value == "") {
            document.getElementById("code_alert").innerHTML = "This field cannot be empty"
            event.preventDefault()
        }else if(document.getElementById('edit') == null){

            document.getElementById("code_alert").innerHTML = ""
            sendAjaxRequest('get', '/api/coupon/' + couponCode.value, null, function(){
                if (this.status !== 404){
                    document.getElementById("code_alert").innerHTML = "There is already a coupon with that code"
                    event.preventDefault()
                }
            })
        }

        let check_empty = ['coupon_name', 'coupon_amount', 'description', 'date']

        for(let i = 0; i < check_empty.length; i++){
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
                event.preventDefault()
            }else{
                document.getElementById(check_empty[i] + "_alert").innerHTML = ""
            }

        }

    }catch(err){
        //alert(err.message)
        event.preventDefault()
    }
}
