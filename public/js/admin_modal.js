// Delete Modal 
var deleteModal = document.getElementById('deleteModal')
if (deleteModal != null) {
    deleteModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')

        var modalUserID = deleteModal.querySelector('#user_id')

        modalUserID.textContent = 'User ID: #' + recipient
    })
}

// Delete product Modal
var deleteProdModal = document.getElementById('deleteProdModal')
if (deleteProdModal != null) {
    deleteProdModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')

        var modalUserID = deleteProdModal.querySelector('#prod_id')

        modalUserID.textContent = 'Product ID: #' + recipient
    })
}

// Accept request Modal
var acceptSupModal = document.getElementById('acceptSupModal')
var yesButton= acceptSupModal.getElementsByClassName('btn btn-primary').item(0);
var noButton=acceptSupModal.getElementsByClassName('btn btn-secondary').item(0);

if (acceptSupModal != null) {
    acceptSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        supplier_id = button.getAttribute('data-bs-whatever')
        requestId = button.getAttribute('request-id')

        var modalUserID = acceptSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + requestId

        
        yesButton.addEventListener('click', function(event) {
            // Yes Button
            var button = event.relatedTarget
                // Extract info from data-bs-* attributes

            $.ajax({
                type: "POST",
                url: '/supplier',
                data: JSON.stringify('supplier_id',supplier_id),
                success: success,
                dataType: JSON
                });

            $.post('/supplier',{'supplier_id':supplier_id}, function(response){
                console.log(response);
            })
    
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open( "POST", 'http://localhost/supplier/accept', false ); // false for synchronous request
            xmlHttp.setRequestHeader('Content-Type', 'application/json');
            console.log(JSON.stringify({
                supplier_id
                }))
            xmlHttp.send(JSON.stringify({
                supplier_id
            }));
        })


    })
    
    
}

// Decline request Modal
var declineSupModal = document.getElementById('declineSupModal')
var yesButton= declineSupModal.getElementsByClassName('btn btn-primary').item(0);
var noButton=declineSupModal.getElementsByClassName('btn btn-secondary').item(0);
if (declineSupModal != null) {
    declineSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        supplier_id = button.getAttribute('data-bs-whatever')
        requestId = button.getAttribute('request-id')

        var modalUserID = declineSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + requestId

        yesButton.addEventListener('click', function(event) {
            // Yes Button
            var button = event.relatedTarget
                // Extract info from data-bs-* attributes
    
            var xmlHttp = new XMLHttpRequest();
            xmlHttp.open( "POST", 'http://localhost/supplier/delete', false ); // false for synchronous request
            xmlHttp.setRequestHeader('Content-Type', 'application/json');
            console.log(JSON.stringify({
                supplier_id
                }))
            xmlHttp.send(JSON.stringify({
                supplier_id
            }));
        })
    })
}