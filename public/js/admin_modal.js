var yesButton;
var noButton;
var id;

// Delete User Modal
var deleteModal = document.getElementById('deleteUserModal')
if (deleteModal != null) {
    yesButton=deleteModal.getElementsByClassName('btn btn-primary').item(0);
    noButton=deleteModal.getElementsByClassName('btn btn-secondary').item(0);

    deleteModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        id = button.getAttribute('data-bs-whatever')
        var name = button.getAttribute('user-name')


        var modalUserID = deleteModal.querySelector('#user_id')

        modalUserID.textContent = 'User ID: #' + id + '\t Name: '+name
    })

    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        sendAjaxRequest('DELETE', '/api/client/'+id, null, function(){
            location.reload();
        })


    });
}

// Delete product Modal
var deleteProdModal = document.getElementById('deleteProdModal')
if (deleteProdModal != null) {
    yesButton=deleteProdModal.getElementsByClassName('btn btn-primary').item(0);
    noButton=deleteProdModal.getElementsByClassName('btn btn-secondary').item(0);
    deleteProdModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        id = button.getAttribute('data-bs-whatever')

        var name = button.getAttribute('prodName')

        var modalUserID = deleteProdModal.querySelector('#prod_id')

        modalUserID.textContent = 'Product ID: #' + id + '\tName:' + name
    })

    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        sendAjaxRequest('DELETE', '/api/item/'+id, null, function(){
            location.reload();
        })


    });

}


// Accept request Modal
var acceptSupModal = document.getElementById('acceptSupModal')
if (acceptSupModal != null) {
    yesButton=acceptSupModal.getElementsByClassName('btn btn-primary').item(0);
    noButton=acceptSupModal.getElementsByClassName('btn btn-secondary').item(0);
    acceptSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        supplier_id = button.getAttribute('data-bs-whatever')
        requestId = button.getAttribute('request-id')

        var modalUserID = acceptSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + requestId


    })

    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        sendAjaxRequest('POST', '/supplier', {"supplier_id":supplier_id, "accept":1}, function(){
             location.reload();
            })


        });

}

// Decline request Modal
var declineSupModal = document.getElementById('declineSupModal')

if (declineSupModal != null) {
    yesButton=declineSupModal.getElementsByClassName('btn btn-primary').item(0);
    noButton=declineSupModal.getElementsByClassName('btn btn-secondary').item(0);
    declineSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
        // Extract info from data-bs-* attributes
        supplier_id = button.getAttribute('data-bs-whatever')
        requestId = button.getAttribute('request-id')

        var modalUserID = declineSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + requestId


    })

    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        sendAjaxRequest('POST', '/supplier', {"supplier_id":supplier_id, "accept":0}, function(){
            location.reload();
            })


        });
}

// Delete Review Modal
deleteModal = document.getElementById('deleteReviewModal')
if (deleteModal != null) {
    yesButton=deleteModal.getElementsByClassName('btn btn-primary').item(0);
    noButton=deleteModal.getElementsByClassName('btn btn-secondary').item(0);

    deleteReviewModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        clientId = button.getAttribute('clientId')
        itemId = button.getAttribute('itemId')

    })

    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        sendAjaxRequest('DELETE', '/api/review', {'client_id':clientId,'item_id':itemId}, function(){
            location.reload();
        })

    });
}
