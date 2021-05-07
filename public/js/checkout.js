let plus = document.getElementsByClassName('plusQuantity')
let minus = document.getElementsByClassName('minusQuantity')



for(let i = 0; i < plus.length; i++){
    plus[i].addEventListener('click', addQuantity)
}

for(let i = 0; i < minus.length; i++){
    minus[i].addEventListener('click', removeQuantity)
}


function addQuantity(event){
    
    let btn = event.target
    let display = btn.parentNode.parentNode.childNodes[1].childNodes[1]

    
    let previousQuantity = display.innerHTML.split(' ')[1]

    display.innerHTML = "Total: " + (parseInt(previousQuantity) + 1)
}

function removeQuantity(event){
    
    let btn = event.target
    let display = btn.parentNode.parentNode.childNodes[1].childNodes[1]

    
    let previousQuantity = display.innerHTML.split(' ')[1]

    display.innerHTML = "Total: " + Math.max((parseInt(previousQuantity) - 1), 0)
}