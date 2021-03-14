<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Search");
navbar();
?>

<?php 
include_once './misc_inc_filters.php'
?>

<div id="mainContainer" class="container">
    <div class="row mb-3 mt-5">
        <div class="col-3">
            <h3> Products </h3>
        </div>
        <div class="col d-inline-flex justify-content-end mb-1">
            <button id="sidebar-toggler" class="btn bd-sidebar-toggle btn-primary" style="width: max-content;"
                type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="filters"
                aria-expanded="false" aria-label="toggle-filters">
                Filters
            </button>
        </div>
        <?php
        include_once '../supplier/order_by.php';
        ?>
    </div>

    <div class="row">
        <?php
        include_once '../supplier/supplier_inc_product_detail_cards.php';
        ?>
    </div>
    <?php
    include_once '../common/common_page_navigation.php';
    ?>
</div>




<?php
footer();
?>


<!-- <?php 
    for ($i=0; $i < 10; $i++) { 
        favProduct(
            $i,
            "Maças verdes",
            "Aqui fica a descrição deste belo produto, fica um bocado mais curta ou até mesmo cortada",
            "1,20",
            "kg"
        );
    }
    ?> -->