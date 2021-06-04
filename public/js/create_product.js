let hasCodeAlready = null

let submit = document.getElementById('form')

submit.addEventListener('submit', validateForm)

function validateForm(event) {
    try {

        let check_empty = ['product_name', 'product_price', 'product_stock', 'description']

        for (let i = 0; i < check_empty.length; i++) {
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
                event.preventDefault()
            }

        }

    } catch (err) {
        //alert(err.message)
        event.preventDefault()
    }
}

// function encodeForAjax(data) {
//     if (data == null) return null;
//     return Object.keys(data).map(function(k) {
//         return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
//     }).join('&');
// }

// function sendAjaxRequest(method, url, data, handler) {

//     let request = new XMLHttpRequest();

//     request.open(method, url, false);
//     if (method != 'get') {
//         request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
//         request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//     }
//     request.addEventListener('load', handler);
//     request.send(encodeForAjax(data));
//     console.log(request.response);
// }

function toastshow() {
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function(toastEl) {
        return new bootstrap.Toast(toastEl, option)
    })

    toast.show()
}

Dropzone.options.myDropzone = {
    url: document.getElementById("form").action,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFiles: 5,
    maxFilesize: 5,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            let csrf = document.querySelector('meta[name="csrf-token"]').content;
            formData.append("_token", csrf);
            formData.append("product_name", document.getElementById("product_name").value);
            formData.append("supplierID", document.getElementById("supplierID").value);
            formData.append("product_price", document.getElementById("product_price").value);
            formData.append("product_type", document.getElementById("product_type").value);
            formData.append("product_stock", document.getElementById("product_stock").value);
            formData.append("description", document.getElementById("description").value);
            formData.append("t", document.getElementById("t").value);

        });
    }
}