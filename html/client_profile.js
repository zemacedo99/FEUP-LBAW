if (window.location.pathname == '/client/client_profile.php')
    setupClientProfile()


if (window.location.pathname == '/supplier/supplier_profile.php') {
    let suppTabContentClasses = document.querySelector('#SupplierTabContent').classList
    let suppProfileClasses = document.querySelector('#supplierProfile').classList
    let suppProductsClasses = document.querySelector('#products').classList

    let profileButtonClasses = document.querySelector('#supplierProfile-tab').classList
    let productsButtonClasses = document.querySelector('#products-tab').classList
    let lgBreakpoint = 992

    let displayFunc = ()=>{
        if (window.innerWidth >= lgBreakpoint) {
            addNotPresent(suppTabContentClasses, 'row')
            addNotPresent(suppProfileClasses, 'show')
            addNotPresent(suppProfileClasses, 'active')
            addNotPresent(suppProductsClasses, 'show')
            addNotPresent(suppProductsClasses, 'active')
        } else {
            removeIfPresent(suppTabContentClasses, 'row')
            if (profileButtonClasses.contains('active')) {
                removeIfPresent(suppProductsClasses, 'active')
                removeIfPresent(suppProductsClasses, 'show')
                addNotPresent(suppProfileClasses, 'show')
                addNotPresent(suppProfileClasses, 'active')
            }
            if (productsButtonClasses.contains('active')) {
                removeIfPresent(suppProfileClasses, 'active')
                removeIfPresent(suppProfileClasses, 'show')
                addNotPresent(suppProductsClasses, 'show')
                addNotPresent(suppProductsClasses, 'active')
            }

        }
    }

    window.addEventListener('resize', displayFunc)

    displayFunc() // run on start
}

function addNotPresent(element, classe) {
    if (!element.contains(classe)) {
        element.add(classe)
    }
}

function removeIfPresent(element, classe){
    if (element.contains(classe)) {
        element.remove(classe)
    }
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