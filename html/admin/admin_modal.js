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
if (acceptSupModal != null) {
    acceptSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')

        var modalUserID = acceptSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + recipient
    })
}

// Decline request Modal
var declineSupModal = document.getElementById('declineSupModal')
if (declineSupModal != null) {
    declineSupModal.addEventListener('show.bs.modal', function(event) {
        // Button that triggered the modal
        var button = event.relatedTarget
            // Extract info from data-bs-* attributes
        var recipient = button.getAttribute('data-bs-whatever')

        var modalUserID = declineSupModal.querySelector('#req_id')

        modalUserID.textContent = 'Request ID: #' + recipient
    })
}