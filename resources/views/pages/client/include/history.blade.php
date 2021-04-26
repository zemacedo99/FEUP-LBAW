<?php
addModal(
    "CancelOrder",
    "Cancelation Confirmation",
    "Are you sure you want to cancel this order?",
    "Cancel",
    "Dismiss"
);
?>

@include('partials.modals.review')

@include('partials.cards.product_in_history')

<?php
historyProduct(
    1,
    "Maças Verdes",
    "4,50",
    "kg",
    "Mesmo interessante este texto sobre maças que o fornecedor foi generoso o suficiente de disponiblizar a dar alguma informação sobre o produto",
    "3,33",
    "cancel"
);

historyProduct(
    1,
    "Maças Vermelhas",
    "3,50",
    "kg",
    "Este é outro texto mega interessante sobre maças vermelhas, boas para comer cruas ou assadas, possuem tamanhos variados, mas parece que a descrição não cabe aqui então vou terminar.",
    "2,50",
    "edit"
);

historyProduct(
    1,
    "Maças Azuis",
    "7,80",
    "kg",
    "Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente tóxico as nossas maças ficam com uma bela cor azul fluorescente.",
    "4,13",
    "leave"
);

?>


