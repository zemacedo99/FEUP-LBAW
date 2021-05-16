let submit= document.getElementById('form')
let add_cc= document.getElementById('add_cc')
let editButtons = document.getElementsByClassName('edit')

submit.addEventListener('submit', validateForm)

add_cc.addEventListener('click', addCC)

for(let i = 0; i < editButtons.length; i++){
    editButtons[i].addEventListener('click', editCC)
}


function validateForm(event) {
    try{
        let check_empty = ['first_name', 'last_name', 'address', 'door_n', 'post_code', 'district', 'city', 'country', 'phone_n']
        let correct = true
        let sd = {}

        for(let i = 0; i < check_empty.length; i++){
            let input = document.getElementById(check_empty[i]);
            if (input.value == "") {
                document.getElementById(check_empty[i] + "_alert").innerHTML = "This field cannot be empty"
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
        if(document.getElementById('save_ship_info').checked){
            sd['to_save'] = true;
        }else{
            sd['to_save'] = false;
        }


        sendAjaxRequest('post', '/api/shipdetails', sd, function(){
            if (this.status !== 200){
                alert(this.status)

            }
            event.preventDefault()
        }, false)


        

    }catch(err){
        alert(err.message)
        event.preventDefault()
    }
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
                save = false;
            }else{
                document.getElementById(check_empty[i] + "_alert").innerHTML = ""
                cc[check_empty[i]] = input.value
            }
           

        }
        if(!save) return;

        sendAjaxRequest('post', '/api/creditcard/', cc, function(){
            if (this.status === 200){
                createCreditCard(cc['holder_name'], cc['card_number'])
                document.getElementById('addCard').modal('hide')

            } 
        }, true)



    }catch(err){
        alert(err.message)
        event.preventDefault()
    }

}

function createCreditCard(card_holder, cc_n){
    let divCards = document.getElementById('all_credit_cards')
    divCards.innerHTML += 
    `<div class="card mb-3">
        <div class="row g-0">
            <div class="col-2">
                <img src="https://via.placeholder.com/80x80" alt="Credit Card default image">
            </div>
            <div class="col-8 col-xl-9 col-sm-9" >
                <div class="card-body">
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"></a>
                    <h6 class="card-title">${card_holder}</h6>
                    <p class="card-text">Visa car Ending in **${cc_n.toString().substr(-2)}</p>
                </div>
            </div>
            <div class="col-1">
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"> <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>

            </div>
        </div>
    </div>`
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
    }, false)
}

function updateCV(i, cc){
    if(cc['card_n'] !== '')
        document.getElementById('card_n_prev:' + i).innerHTML = "Visa car Ending in **" + cc['card_n'].substr(-2)
    
    if(cc['holder'] !== '')
        document.getElementById('holder_prev:' + i).innerHTML = cc['holder']
    
}


function encodeForAjax(data) {
    if (data == null) return null;
    return Object.keys(data).map(function(k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function sendAjaxRequest(method, url, data, handler, async) {

    let request = new XMLHttpRequest();

    request.open(method, url, async);
    if (method != 'get') {
        request.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    }
    request.addEventListener('load', handler);
    request.send(encodeForAjax(data));

}