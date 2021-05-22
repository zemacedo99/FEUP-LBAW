let hasCodeAlready = null

let submit= document.getElementById('form')

submit.addEventListener('submit',validateForm)

function validateForm(event) {
    try{

        let check_empty = ['product_name', 'product_price' , 'product_stock', 'description']

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
