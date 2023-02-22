let last_i = 0

var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
 
addAllListeners()

function addAllListeners(){
    let submit= document.getElementById('form')
    let add_cc= document.getElementById('add_cc')
    let editButtons = document.getElementsByClassName('edit')
    let deleteButtons = document.getElementsByClassName('delete')
    let selectButtons = document.getElementsByClassName('select')

    submit.addEventListener('submit', validateForm)

    add_cc.addEventListener('click', addCC)

    for(let i = 0; i < editButtons.length; i++){
        editButtons[i].addEventListener('click', editCC)
        deleteButtons[i].addEventListener('click', deleteCC)
        selectButtons[i].addEventListener('click', selectCC)
    }
    last_i = editButtons.length - 1

}

function validateForm(event) {
    try{

        let cc_id =  document.getElementById('selected_id').value

        if(cc_id  <= 0){
            document.getElementById("cc_alert").innerHTML = "You must select a credit card"
            event.preventDefault()
        }else {
            document.getElementById("cc_alert").innerHTML = ""
        }
        let check_empty = ['first_name', 'last_name', 'address', 'door_n', 'post_code', 'district', 'city', 'country', 'phone_n']
        let correct = true
        let sd = {}

        for(let i = 0; i < check_empty.length; i++){
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
                correct = false

            }else if(check_empty[i] === 'door_n' && !verifyIfNumber(input.value)){
                document.getElementById(check_empty[i] + "_alert").innerHTML = "Door nº must be a number"
                correct = false
            }else{
                document.getElementById(check_empty[i] + "_alert").innerHTML = ""
                sd[check_empty[i]] = input.value
            }
        }

        if(!correct){
            event.preventDefault()
            return
        }
        sd['to_save'] = document.getElementById('save_ship_info').checked;

        let sp_id = -1
        sendAjaxRequest('post', '/api/shipdetails', sd, function(){
            if (this.status === 201){
                document.getElementById('sd_id').value = JSON.parse(this.responseText).id
            }else{
                event.preventDefault()
                sp_id = -2
            }
        }, false)

        if(sp_id == -2){
            console.log("Error in shipdetail")
        }

    }catch(err){
        console.log(err.message)
        event.preventDefault()
    }
}

function selectCC(event){
    let i = event.target.getAttribute('id').split(':')[1]
    let id = document.getElementById('cc_id:' + i).value
    let lastI = document.getElementById('selected_i').value

    if(lastI >= 0){
        document.getElementById('card:' + lastI).style.borderWidth = "0px"
        document.getElementById('card:' + lastI).style.borderColor = "green"
    }

    document.getElementById('selected_id').value = id
    document.getElementById('selected_i').value = i
    document.getElementById('card:' + i).style.borderWidth = "thick"
    document.getElementById('card:' + i).style.borderColor = "green"
}



function addCC(event){
    try{
        let check_empty = ['card_number', 'valid_until', 'cvv', 'holder_name']
        let save = true
        let cc = {}

        for(let i = 0; i < check_empty.length; i++){
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
                save = false
            }else{
                if(check_empty[i] === 'cvv' && !verifyIfNumber(input.value, 3)){
                    document.getElementById(check_empty[i] + "_alert").innerHTML = "CVV must have 3 digit"
                    save = false

                }else if(check_empty[i] === 'card_number' && !verifyIfNumber(input.value, 16)){
                    document.getElementById(check_empty[i] + "_alert").innerHTML = "Card number must have 16 digits"
                    save = false

                }else{
                    
                    document.getElementById(check_empty[i] + "_alert").innerHTML = ""
                    if(check_empty[i] !== 'card_number')
                        cc[check_empty[i]] = input.value
                    else
                        cc[check_empty[i]] = deleteAllWhitespaces(input.value)
                }

            }


        }
        if(!save){
            event.preventDefault()
            return;
        }


        cc['to_save'] = document.getElementById('save_cc').checked;


        sendAjaxRequest('post', '/api/creditcard/', cc, function(){

            console.log(this.status)
            console.log(this.responseText)
            if (this.status === 201){
                var myModal = new bootstrap.Modal(document.getElementById('addCard'), null)
                console.log(myModal);
                myModal.hide()
                createCreditCard(JSON.parse(this.responseText))

            }
        }, true)



    }catch(err){
        alert(err.message)
        event.preventDefault()
    }

}

function verifyIfNumber(input, desLength){
    let clean =  deleteAllWhitespaces(input)     
    if(desLength != undefined)
        return !isNaN(clean) && clean.length === desLength
    else
        return !isNaN(clean)
}

function deleteAllWhitespaces(input){
    return input.replace(/\s+/g, '')
}

function createCreditCard(cc){
    let divCards = document.getElementById('all_credit_cards')
    let i = ++last_i

    divCards.innerHTML +=
    `<div class="card mb-3" id="card:${i}">
        <div class="row g-0">
            <div class="col-2">
                <img src="https://via.placeholder.com/80x80" alt="Credit Card default image">
            </div>
            <div class="col-8 col-xl-9 col-sm-9" >
                <div class="card-body">
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard_${i}"></a>
                    <h6 class="card-title" id="holder_prev:${i}">${cc.holder}</h6>
                    <p class="card-text" id="card_n_prev:${i}">Visa car Ending in **${cc.card_n.toString().substr(-2)}</p>
                </div>
            </div>
            <div class="col-1">
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard_${i}"> <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>

            </div>
        </div>
    </div>
    <div class="modal fade " id="editCard_${i}" tabindex="-1" aria-labelledby="editCardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardLabel">Edit Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" value="${cc.id}" id="cc_id:${i}" >
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="card_number:${i}" name="card_number" value="${cc.card_n}">
                            <label for="card_number">Card number</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="month" class="form-control" id="valid_until:${i}" name="valid_until" placeholder="Valid until" value ="${cc.expiration}">
                                <label for="valid_until">Valid until</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="cvv:${i}" name="cvv" placeholder="CVV" value ="${cc.cvv}">
                                <label for="cvv">CVV</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="holder_name:${i}" name="holder_name" value ="${cc.holder}">
                            <label for="holder_name_e">Card holder</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="button" id="delete:${i}" class="btn btn-danger btn-sm delete" data-bs-dismiss="modal"><i class="bi bi-trash"></i> Delete this card</button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" id="select:${i}" class="btn btn-primary select" data-bs-dismiss="modal">Select Card</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="edit:${i}" data-bs-dismiss="modal" class="btn btn-primary edit">Edit Card</button>
                </div>
            </div>
        </div>
    </div>`
    addAllListeners()
}

function editCC(event){
    let i = event.target.getAttribute('id').split(':')[1]
    let id = document.getElementById('cc_id:' + i).value
    let card_n = document.getElementById('card_number:' + i).value
    let expiration = document.getElementById('valid_until:' + i).value
    let cvv = document.getElementById('cvv:' + i).value
    let holder = document.getElementById('holder_name:' + i).value


    cc = {}
    cc['id'] = id

    if(card_n !== '')
        cc['card_n'] = card_n

    if(expiration !== '')
        cc['expiration'] = expiration

    if(cvv !== '')
        cc['cvv'] = cvv

    if(holder !== '')
        cc['holder'] = holder


    sendAjaxRequest('put', '/api/creditcard/', cc, function(){
        if (this.status !== 200){
            alert(this.status)
        }
        updateCV(i, cc)
    }, true)
}

function deleteCC(event){
    let i = event.target.getAttribute('id').split(':')[1]
    let id = document.getElementById('cc_id:' + i).value

    sendAjaxRequest('delete', '/api/creditcard/', { 'id' : id}, function(){
        if (this.status !== 200){
            alert(this.status)
        }
        deleteCCPage(i)
    }, true)

}


function deleteCCPage(i){
    let card = document.getElementById("card:" + i)
    let editCard = document.getElementById("editCard_" + i)
    card.parentNode.removeChild(card)
    editCard.parentNode.removeChild(editCard)
}



function updateCV(i, cc){
    if(cc['card_n'] !== '')
        document.getElementById('card_n_prev:' + i).innerHTML = "Visa car Ending in **" + cc['card_n'].substr(-2)

    if(cc['holder'] !== '')
        document.getElementById('holder_prev:' + i).innerHTML = cc['holder']

}
