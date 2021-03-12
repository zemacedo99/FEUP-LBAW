<?php 
include_once './client_inc_product_cards.php';
addModal("DeletePeriodic", 
        "Confirmation", 
        "Are you sure you want to cancel this periodic purchase?",
        "Delete",
        "Cancel");

periodicProduct(
    1,
    "Maças Azuis",
    "7,80",
    "kg",
    "Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente tóxico as nossas maças ficam com uma bela cor azul fluorescente.",
    "4,13",
    "Weekly on Mondays");

periodicProduct(
    2,
    "Abacaxi",
    "5,30",
    "kg",
    "Uns bons abacaxis, suculentos, e naturais",
    "2,57",
    "Daily");

periodicProduct(
    3,
    "Laranjas",
    "2,70",
    "kg",
    "Aquela descrição foi bem curta, pena que a estas horas da noite não dá para mais",
    "3,89",
    "Monthly on the 3rd");

?>
