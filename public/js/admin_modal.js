var yesButton;
var noButton;

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
    
    };

    


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




function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}
function sendAjaxRequest(method, url, data, handler) {

    let request = new XMLHttpRequest();

    request.open(method, url, false);
    if (method != 'get') {
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));

}