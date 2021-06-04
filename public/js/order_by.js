let order_by = document.getElementById("orderby");

order_by.addEventListener('change', (event) => {
    let results = order_by.value;
    console.log(results);

    sendAjaxRequest('get', window.location.href, { 'order_by': results }, function() {})
});