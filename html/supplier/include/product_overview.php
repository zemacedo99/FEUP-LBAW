<?php
/**
 * Creates a card for the product overview in the supplier
 */
function suppOverviewCard($id, $name, $price, $unit, $description) { ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-3 col-md-2 col-lg-3 col-xl-2">
                <img src="https://via.placeholder.com/100x100" alt="...">
            </div>
            <div class="col-9 col-md-10 col-lg-9 col-xl-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between justify-content-md-start">
                        <h4 class="card-title"><?=$name?></h4>
                    </div>
                    <h6 class="card-subtitle text-muted"><?=$price?>€/<?=$unit?></h6>

                    <div class="row row-cols-1 row-cols-md-2">
                        <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                            <?=$description?>
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="container-sm">
    <div class="row d-flex justify-content-center d-none d-lg-flex mt-3 fs-3 mb-5">Products</div>

    <div class="row mb-5 mt-2">
        <div class="col-5 d-flex justify-content-center">
            <a href="../supplier/create_product.php"><button type="button" class="btn btn-primary"><i class="bi bi-plus"></i> Add a Product</button></a>
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
        <a href="../supplier/all_products.php" class="link-dark">See all Products</a>
    </div>

</div>
