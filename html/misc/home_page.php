<?php
include_once '../common/extras.php';
include_once './include/homepage_products.php';
pageHeader("MyGarden");
navbar();
?>

<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-md-10"> 
            <img class="img-fluid" src="../images/garden.jpg" alt="Photo of a garden"    height="400px">
        </div>
    </div>
    
    <?php 
        product_row("Almost Sold Out", "clock");
    ?>

    <?php 
        product_row("Hot", "sun");
    ?>
    
    <?php 
        product_row("New", "newspaper");
    ?>
    
    <div class="row my-5">
        <div class="col"></div>
        <div class="col-6 col-md-4 col-lg-3 text-end">
            <a href="/misc/productList.php" class="link-secondary">See all products<i class="bi bi-arrow-right-short"></i></a>
        </div>
    </div>

</div>

<?php
footer();
?>