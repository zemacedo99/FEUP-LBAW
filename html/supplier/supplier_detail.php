<?php
include_once '../common/extras.php';
pageHeader("MyGarden - Supplier");
navbar();
?>

<div id="mainContainer" class="container">


    <div class="row mt-5 ">



        <div class="col-3" style="width: 15rem;">
            <img src="../images/batata-amarela.jpg" class="rounded-circle img-fluid">
        </div>
        <div class="col-9 sm-12">
            <div class="col-9">
                <h3>Quinta do Bill</h3>
            </div>
            <div class="col-1">
                <i class="bi bi-envelope text-end"></i>
            </div>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <textarea class="form-control" rows="5"
            readonly>Quinta do Bill has been present in the Portuguese market since 1987. This renowned company is recognized in the national market and some restrict international markets for its high quality standards. This store helps costumers reach out to the full extent of our products.</textarea>


    </div>

    <div class="row mb-3">
        <div class="col-3">
            <h3> Products </h3>
        </div>
        <?php
    include_once './order_by.php';
    ?>
    </div>

    <div class="row">
        <?php
    include_once './supplier_inc_product_detail_cards.php';
    ?>
    </div>
    <?php
    include_once '../common/common_page_navigation.php';
    ?>
</div>

<?php
footer();
?>