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
