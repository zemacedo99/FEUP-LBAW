function favoriteAddRemove(item,button){
    let icon=button.childNodes[1];
    if(icon.classList.contains("bi-suit-heart-fill")){
        //send request to take favourite to item->id
        sendAjaxRequest('PUT', '/favorite', {"item_id":item["id"],"favorite":0}, function(){
            //location.reload();
            //TODO:check if response is 204
            icon.classList.remove("bi-suit-heart-fill");
            icon.classList.add("bi-suit-heart");
        })
        
        
    }else{
        //send request to put favourite to item->id
        sendAjaxRequest('PUT', '/favorite', {"item_id":item["id"],"favorite":1}, function(){
            //location.reload();
            //TODO:check if response is 204
            icon.classList.remove("bi-suit-heart");
            icon.classList.add("bi-suit-heart-fill");

        })
        
    }
}