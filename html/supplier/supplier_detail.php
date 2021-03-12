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

    <div class="row">
        <div class="col-3">
            <h3> Products </h3>
        </div>
        <div class="col-md-1 ms-sm-auto col-lg-2 px-md-1">
            <select class="form-select" aria-label="Relevance">
                <option selected>Order by:</option>
                <option value="Price Up">Price Up</option>
                <option value="Price Down">Price Down</option>
                <option value="Review Up">Review Up</option>
                <option value="Review Down">Review Down</option>
                <option value="Relevance">Relevance</option>
            </select>
        </div>
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