let suppTabContentClasses = document.querySelector('#SupplierTabContent').classList
let suppProfileClasses = document.querySelector('#supplierProfile').classList
let suppProductsClasses = document.querySelector('#products').classList

let profileButtonClasses = document.querySelector('#supplierProfile-tab').classList
let productsButtonClasses = document.querySelector('#products-tab').classList
let lgBreakpoint = 992

let displayFunc = () => {
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

function addNotPresent(element, classe) {
    if (!element.contains(classe)) {
        element.add(classe)
    }
}

function removeIfPresent(element, classe) {
    if (element.contains(classe)) {
        element.remove(classe)
    }
}


// Delete supplier profile Modal
var deleteProfileModal = document.getElementById('modalDeleteSupplierAccount')
if (deleteProfileModal != null) {
    var yesButton=deleteProfileModal.getElementsByClassName('btn btn-primary').item(0);
    var noButton=deleteProfileModal.getElementsByClassName('btn btn-secondary').item(0);
    yesButton.addEventListener("click", function(event) {
        // Yes Button
        var button = event.relatedTarget;

            // Extract info from data-bs-* attributes

        var supplierId=window.location.pathname.split("/").slice(-1)[0];
        
        sendAjaxRequest('DELETE', '/supplier/'+supplierId, null, function(){
            window.location.replace("/");
        })


    });

}
