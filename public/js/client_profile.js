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

    let first_name = document.querySelector('#floatingFirstName')
    let last_name = document.querySelector('#floatingLastName')
    let address = document.querySelector('#floatingAddress')
    let door = document.querySelector('#floatingDoor')
    let zip_code = document.querySelector('#floatingZipcode')
    let district = document.querySelector('#floatingDistrict')
    let city = document.querySelector('#floatingCity')
    let country = document.querySelector('#floatingCountry')
    let phone = document.querySelector('#floatingPhone')

    document.querySelector('#update_data').addEventListener("click", () => {
        console.log(`Id: ${id}\nName: ${profile_name.value}\nEmail: ${email.value}\nPassword: ${password.value}\nFirst Name: ${first_name.value}\nLast Name: ${last_name.value}
        \nAddress: ${address.value}\nDoor: ${door.value}\nZip Code: ${zip_code.value}\nDistrict: ${district.value}\nCity: ${city.value}\nCountry: ${country.value}\nPhone: ${phone.value}`)

        sendAjaxRequest('put', '/api/client/' + id, {email: email.value, password: password.value, name: profile_name.value}, updateProfileHandler)
    })
}

function updateProfileHandler(){
    console.log("Não imprime o de baixo...")
    let response = JSON.parse(this.responseText);
    console.log("Response:", this.responseText)
}

setupClientProfile()
updateProfile()
