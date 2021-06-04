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
    headers: {
        'X-CSRF-Token': document.querySelector('meta[name="csrf-token"]').content
    },
    init: function() {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

        myDropzone = this;
        
        if(document.getElementById("product_name").value!=""){
        let prodId=window.location.href.split("/").slice(-1)[0];
        sendAjaxRequest('get',"/product/images/"+prodId,null,function(response){
            console.log(response);
            response=JSON.parse(response.currentTarget.response);
            console.log(response);
            console.log(typeof(response));

            var mockFile;
            for (let i=0; i<response.length; i++){
                mockFile = { name: response[i].id, size: response[i].size};

                // myDropzone.emit("addedfile", mockFile);
                // myDropzone.emit("thumbnail", mockFile, response[i].path);
                // myDropzone.createThumbnailFromUrl(mockFile,
                //     myDropzone.options.thumbnailWidth, 
                //     myDropzone.options.thumbnailHeight,
                //     myDropzone.options.thumbnailMethod, true, function (thumbnail) 
                //         {
                //             myDropzone.emit('thumbnail', mockFile, thumbnail);
                //         });

                // myDropzone.emit("complete", mockFile);
                myDropzone.displayExistingFile(mockFile, response[i].path);
                myDropzone.files.push(mockFile);
            }
            
        });
        }
            
            

        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("submit").addEventListener("click", function(e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();
        });

        //send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            formData.append("product_name", document.getElementById("product_name").value);
            formData.append("supplierID", document.getElementById("supplierID").value);
            formData.append("product_price", document.getElementById("product_price").value);
            formData.append("product_type", document.getElementById("product_type").value);
            formData.append("product_stock", document.getElementById("product_stock").value);
            formData.append("description", document.getElementById("description").value);
            formData.append("t", document.getElementById("t").value);
            let s="";
            for (let i=0;i<myDropzone.files.length;i++){
                s+=myDropzone.files[i].name+" ,";
            }
            formData.append("oldPhotos", s);
            console.log(myDropzone.files);

        });

        myDropzone.on("success", function(file, responseText) {
            window.location.href = "/items/"+responseText;
          });
      
    }
}

// --------------------------- Delete Product -----------------------------------------//

document.getElementById("deleteProduct").addEventListener("click", deleteProduct);

function deleteProduct(event){
    let product_id = window.location.href.split("/").slice(-1)[0];
    
    sendAjaxRequest('delete', '/api/product/' + product_id, null, function(){
        if(this.status == 204){ window.location.href=document.referrer}
        else alert("Something went wrong when deleting the product")
    })
}
