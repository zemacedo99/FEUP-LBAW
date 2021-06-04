/**
 * Pode ser melhorado:
 * - Buscar todos os botões que não são profile em vez de hardcoded
 */
function setupClientProfile() {
    let profileClasses = document.querySelector('#profileHeader').classList;
    let profileButton = document.querySelector('#HideProfileButton');
    let profileEvent = () => {
        if (!profileClasses.contains("show")) {
            eventFire(profileButton, 'click')
        }
    }

    document.querySelector('#pills-profile-tab').addEventListener('click', () => {
        if (profileClasses.contains("show")) {
            eventFire(profileButton, 'click')
        }
    })

    document.querySelector('#pills-periodic-buys-tab').addEventListener('click', profileEvent)
    document.querySelector('#pills-favorites-tab').addEventListener('click', profileEvent)
    document.querySelector('#pills-purchase-history-tab').addEventListener('click', profileEvent)
}

/**
 * https://stackoverflow.com/questions/2705583/how-to-simulate-a-click-with-javascript/2706236#2706236
 * eventFire(document.getElementById('mytest1'), 'click');
 * @param {Element} el Element where event will happen
 * @param {Event} etype Type of event
 */
function eventFire(el, etype) {
    if (el.fireEvent) {
        el.fireEvent('on' + etype);
    } else {
        var evObj = document.createEvent('Events');
        evObj.initEvent(etype, true, false);
        el.dispatchEvent(evObj);
    }
}

function updateProfile(){
    let profile_name = document.querySelector('#ClientName')
    let id = profile_name.getAttribute('data-id');
    let email = document.querySelector('#clientEmail')
    let password = document.querySelector('#clientPassword')

    document.querySelector('#update_data').addEventListener("click", () => {
        sendAjaxRequest('put', '/api/client/' + id, {email: email.value, password: password.value, name: profile_name.value}, updateProfileHandler)
    })
}

function updateShipping(){
    let id = document.querySelector('#ClientName').getAttribute('data-id');
    let first_name = document.querySelector('#floatingFirstName')
    let last_name = document.querySelector('#floatingLastName')
    let address = document.querySelector('#floatingAddress')
    let door = document.querySelector('#floatingDoor')
    let zip_code = document.querySelector('#floatingZipcode')
    let district = document.querySelector('#floatingDistrict')
    let city = document.querySelector('#floatingCity')
    let country = document.querySelector('#floatingCountry')
    let phone = document.querySelector('#floatingPhone')

    document.querySelector('#update_shipping').addEventListener("click", () => {
        sendAjaxRequest('put', '/api/client/' + id + '/shipping',
            {first_name: first_name.value,
                last_name: last_name.value,
                address: address.value,
                door_n: door.value,
                post_code: zip_code.value,
                district: district.value,
                city: city.value,
                country: country.value,
                phone_n: phone.value,
            }, updateShippingHandler)
    })
}

function updateProfileHandler(){
    let list_div = document.querySelector('#error-message')
    let list = list_div.children[0]

    if(this.status === 400){
        list_div.removeAttribute("hidden")
        list_div.className = "alert alert-danger"
        let response = JSON.parse(this.responseText)
        list.innerHTML = ""

        for (index in response){
            let list_item = document.createElement('li')
            list_item.appendChild(document.createTextNode(response[index]))
            list.appendChild(list_item)
        }
    } else if (this.status === 204) {
        list_div.removeAttribute("hidden")
        list_div.className = "alert alert-success"
        list.innerHTML = ""
        let list_item = document.createElement('li')
        list_item.appendChild(document.createTextNode("Client changes made successfully"))
        list.appendChild(list_item)
    }
}

function updateShippingHandler(){
    let list_div = document.querySelector('#error-message')
    let list = list_div.children[0]

    if(this.status === 400){
        list_div.removeAttribute("hidden")
        list_div.className = "alert alert-danger"
        let response = JSON.parse(this.responseText)
        list.innerHTML = ""

        for (index in response){
            let list_item = document.createElement('li')
            list_item.appendChild(document.createTextNode(response[index]))
            list.appendChild(list_item)
        }
    } else if (this.status === 204) {
        list_div.removeAttribute("hidden")
        list_div.className = "alert alert-success"
        list.innerHTML = ""
        let list_item = document.createElement('li')
        list_item.appendChild(document.createTextNode("Shipping changes made successfully"))
        list.appendChild(list_item)
    }
}

setupClientProfile()
updateProfile()
updateShipping()

// ---------------------- History ----------------------------------------------//

historyModals()

function historyModals(){
    let cancelOrderModal = document.getElementById('modalCancelOrder')
    cancelOrderModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = event.relatedTarget
        // Extract info from data-bs-* attributes
        let recipient = button.getAttribute('data-bs-whatever')
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.

        // Update the modal's content.
        let modalBodyInput = cancelOrderModal.querySelector('.product_id_modal')

        modalBodyInput.value = recipient
    })
    let reviewModal = document.getElementById('modalReview')
    reviewModal.addEventListener('show.bs.modal', function (event) {
        // Button that triggered the modal
        let button = event.relatedTarget
        // Extract info from data-bs-* attributes
        let recipient = button.getAttribute('data-bs-whatever')
        let productName = button.getAttribute('data-bs-product_name')
        
        // If necessary, you could initiate an AJAX request here
        // and then do the updating in a callback.

        // Update the modal's content.
        let modalBodyInput = reviewModal.querySelector('#product_id_review')
        reviewModal.querySelector('#product_name').innerHTML = productName
        modalBodyInput.value = recipient
    })

}

document.getElementById('YesButtonModal').addEventListener('click', cancelOrder)
document.getElementById('ConfirmReviewBtn').addEventListener('click', addReview)
document.getElementById('deleteReview').addEventListener('click', removeReview)


function cancelOrder(event){
    console.log(event)

    let product_id = event.target.parentNode.parentNode.parentNode.querySelector('.product_id_modal').value
    let client_id = document.getElementById('client_id').value
    
    sendAjaxRequest('put', '/api/client/' + client_id + '/purchases',
    {'product_id': product_id}, function(){
        location.reload()
    })
}

function addReview(event){
    let product_id = document.getElementById('product_id_review').value
    let client_id = document.getElementById('client_id').value
    let rating = document.getElementById('rating').value
    let comment = document.getElementById('comment').value
    



    sendAjaxRequest('post', '/api/' + client_id + '/review' ,
    {'item_id': product_id, 'rating': rating, 'description': comment}, function(){
        if(this.status == 204) alert("Deleted review")
        else alert("Something went wrong when deleting the review") 
    })
}


function removeReview(){
    let product_id = document.getElementById('product_id_review').value
    let client_id = document.getElementById('client_id').value

    sendAjaxRequest('delete', '/api/' + client_id + '/review' ,
    {'item_id': product_id}, function(){
        alert(this.status)
        alert(this.responseText)
        
    })
}