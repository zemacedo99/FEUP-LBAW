let order_by = document.getElementById("orderby");
let form = order_by.parentElement.parentElement;
// console.log(form);

order_by.addEventListener('change', (event) => {
    let results = order_by.value;

    form.submit();
});