<?php
include_once './supplier_inc_prod_overview_card.php'
?>
<div class="container-sm">
    <div class="row d-flex justify-content-center d-none d-lg-flex mt-3 fs-3 mb-5">Products</div>

    <div class="row mb-5 mt-2">
        <div class="col-5 d-flex justify-content-center">
            <a href="../supplier/supplier_create_product.php"><button type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Add a Product</button></a>
        </div>
        <div class="col-7 d-flex justify-content-center">
            <a href="../supplier/bundles_and_cupons.php"><button type="button" class="btn btn-primary"> <i class="bi bi-bag-fill"></i> Bundles and <i class="bi bi-cash"></i> Cupons <i class="bi bi-caret-right"></i></button></a>
        </div>
    </div>

    <?php
    for ($i = 0; $i < 4; $i++) {
        suppOverviewCard(
            $i,
            "Maças Vermelhas",
            "3,50",
            "kg",
            "Este é outro texto mega interessante sobre maças vermelhas, boas para comer cruas ou assadas, possuem tamanhos variados, mas parece que a descrição não cabe aqui então vou terminar."
        );
    }
    ?>

    <div class="row">
        <a href="../supplier/supplier_all_products.php" class="link-dark">See all Products</a>
    </div>

</div>