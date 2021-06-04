function addItem() {
    var div = document.getElementById("dynamic_tags");
    var tags = document.getElementById("tags");


    if (tags.value !== "") {
        var btn = document.createElement("button");
        btn.type = 'button';
        btn.innerHTML = tags.value;
        btn.className = 'btn btn-secondary btn-sm me-2 mb-1';
        btn.setAttribute('id', tags.value);
        btn.setAttribute('onclick', 'removeOnBtn( "' + tags.value + '" )');
        div.appendChild(btn);
        var t = document.getElementById("t");
        t.value += tags.value + "/";
    }

}

function removeItem() {
    var div = document.getElementById("dynamic_tags");
    var tags = document.getElementById("tags");
    var item = document.getElementById(tags.value);
    div.removeChild(item);
}

function removeOnBtn(element) {
    var div = document.getElementById("dynamic_tags");
    var item = document.getElementById(element);
    div.removeChild(item);


    var t = document.getElementById("t").value;
    // console.log("t:  " + t);
    // console.log("element:  " + element + "/");

    let newt = t.replace(element + "/", "");

    // console.log("t after replace element:  " +  newt);

    document.getElementById("t").setAttribute('value', newt);

}

function addTag(tag) {

    var div = document.getElementById("dynamic_tags");

    var btn = document.createElement("button");
    btn.type = 'button';
    btn.innerHTML = tag;
    btn.className = 'btn btn-secondary btn-sm me-2 mb-1';
    btn.setAttribute('id', tag);
    btn.setAttribute('onclick', 'removeOnBtn( "' + tag + '" )');
    div.appendChild(btn);
    var t = document.getElementById("t");
    t.value += tag + "/";

}