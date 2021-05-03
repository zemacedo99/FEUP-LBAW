<?php
function historyProduct($id, $name, $price, $unit, $description, $paid, $type)
{
?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                <img src="https://via.placeholder.com/150x150" alt="...">
            </div>
            <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between justify-content-md-start">
                        <h4 class="card-title text-truncate"><?= $name ?></h4>
                        <i class="bi bi-cart-plus ps-md-4"></i>
                    </div>
                    <h6 class="card-subtitle text-muted"><?= $price ?>€/<?= $unit ?></h6>

                    <div class="row row-cols-1 row-cols-md-2">
                        <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9"> <?= $description ?> </p>
                        <h4 class="card-title text-end text-md-start order-md-3"><?= $paid ?>€</h4>
                        <div class="text-center order-md-2 col-md-3 col-lg-3 overdiv">
                            <?php
                            switch ($type) {
                                case 'cancel': ?>
                                    <button type="button" class="btn btn-secondary text-truncate" data-bs-toggle="modal" data-bs-target="#modalCancelOrder"><i class="bi bi-x"></i> Cancel Order</button>
                                <?php break;
                                case 'edit': ?>
                                    <button type="button" class="btn btn-primary text-truncate" data-bs-toggle="modal" data-bs-target="#modalReview"><i class="bi bi-list"></i> Edit Review</button>
                                <?php break;
                                case 'leave': ?>
                                    <button type="button" class="btn btn-success text-truncate"><i class="bi bi-plus"></i> Leave a Review</button>
                                <?php break;
                                default: ?>
                                    <p>There was an error, our monkeys are working to fix it</p>
                            <?php break;
                            }
                            ?>

                        </div>
                    </div>
                    <a href="{{ url('/misc/product_detail') }}" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>