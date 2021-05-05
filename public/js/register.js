let inputs = document.querySelectorAll('.panel-body input, .panel-body textarea')

document.querySelector('#flexRadioDefault1').addEventListener('change', () => {
    inputs.forEach(element => {
        element.required = false
    })
})

document.querySelector('#flexRadioDefault2').addEventListener('change', () => {
    inputs.forEach(element => {
        element.required = true
    })
})
