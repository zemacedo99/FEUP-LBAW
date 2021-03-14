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
        <div class="col-8 sm-12">
            <div class="col-9 mt-3">
                <h3>Quinta do Bill</h3>
            
                <p class="text-muted"><i>Póvoa do Varzim, Portugal</i></p>
            
                <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star"></i><i class="bi bi-star"></i>
            </div>
        </div>
        <div class="col-1 mt-3">
            <i class="bi bi-envelope"></i>
        </div>
    </div>

    <div class="row mt-5 mb-5">
        <p class="text-start rounded" style="background-color: #F3F2F4;">
            Quinta do Bill has been present in the Portuguese market since 1987. This renowned company is recognized in the national market and some restrict international markets for its high quality standards. This store helps costumers reach out to the full extent of our products.
        </p>


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