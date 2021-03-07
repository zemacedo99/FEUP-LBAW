if (window.location.pathname == '/client/client_profile.php')
    setupClientProfile()
    

if (window.location.pathname == '/supplier/supplier_profile.php') {
    let SuppTabClasses = document.querySelector('#SupplierTab').classList
    let lgBreakpoint = 992
    let displayFunc = ()=>{
        if (window.innerWidth >= lgBreakpoint) {
            if (!SuppTabClasses.contains('d-none')) {
                SuppTabClasses.add('d-none')
            }
        } else {
            SuppTabClasses.remove('d-none')
        }
    }


    window.addEventListener('resize', displayFunc)

    displayFunc() // run on start
}


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