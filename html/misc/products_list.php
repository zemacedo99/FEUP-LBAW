<?php
include_once '../common/extras.php';
include_once './include/filters.php';

pageHeader("MyGarden - Search");
navbar();
?>

<div id="mainContainer" class="container">
    <div class="row mb-3 mt-5">
        <div class="col-3">
            <h3> Products </h3>
        </div>
        <div class="col d-inline-flex justify-content-end mb-1">
            <button id="sidebar-toggler" class="btn bd-sidebar-toggle btn-primary" style="width: max-content;" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="filters" aria-expanded="false" aria-label="toggle-filters">
                Filters
            </button>
        </div>
        <?php
        include_once '../supplier/order_by.php';
        ?>
    </div>

    <div class="row">
        <?php
        include_once '../supplier/include/product_detail_cards.php';
        ?>
    </div>
    <?php
    include_once '../common/page_navigation.php';
    ?>
</div>

<?php
footer();
?>