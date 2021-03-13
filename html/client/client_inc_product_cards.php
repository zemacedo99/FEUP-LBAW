<?php
function favProduct($id, $name, $description, $price, $unit)
{
?>

    <div class="col">
        <div class="card">
            <img src="https://via.placeholder.com/100x100" class="card-img-top" alt="...">
            <div class="card-img-overlay d-flex justify-content-end">

                <label for="favorite<?=strval($id)?>" class="favorite-checkbox">
                    <input type="checkbox" checked id="favorite<?=strval($id)?>" />
                    <i class="bi bi-heart"></i>
                    <i class="bi bi-heart-fill"></i>
                </label>

            </div>
            <div class="card-body">
                <h5 class="card-title"><?= $name ?></h5>
                <p class="card-text d-none d-md-block"><?= $description ?></p>
                <h6 class="card-title text-end text-md-start order-md-3"><?= $price ?>€/<?= $unit ?></h6>
            </div>
        </div>
    </div>

<?php
}
?>

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
                        <h4 class="card-title text-truncate"><?=$name?></h4>
                        <i class="bi bi-cart-plus ps-md-4"></i>
                    </div>
                    <h6 class="card-subtitle text-muted"><?=$price?>€/<?=$unit?></h6>

                    <div class="row row-cols-1 row-cols-md-2">
                        <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9"> <?=$description?> </p>
                        <h4 class="card-title text-end text-md-start order-md-3"><?=$paid?>€</h4>
                        <div class="text-center order-md-2 col-md-3 col-lg-3">
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

                </div>
            </div>
        </div>
    </div>
<?php
}
?>

<?php
function periodicProduct($id, $name, $price, $unit, $description, $paying, $periodicity){
?>
<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img src="https://via.placeholder.com/150x150" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2">
                    <div class="col col-md-9 ">
                        <div class="row d-flex align-content-around flex-wrap">
                            <div class="col col-12 col-md-6 order-md-1">
                                <h5 class="card-title"><?=$name?></h5>
                            </div>
                            <div class="col col-6  col-md-12 order-md-3">
                                <h6 class="card-subtitle text-muted"><?=$price?>€/<?=$unit?></h6>
                            </div>
                            <div class="col text-truncate d-none d-md-block col-md-12 order-md-4 "><?=$description?></div>
                            <div class="col coo-12 order-md-5">
                                <h4 class="card-title text-end text-md-start order-md-3"><?=$paying?>€</h4>
                            </div>
                            <div class="col coo-12 col-md-6 order-md-2">
                                <h6 class="card-title text-center text-md-end"><?=$periodicity?></h6>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tem de se mudar o Sass para que a class btn-group-vertical possa ser ativada com breakpoints https://stackoverflow.com/questions/46808709/bootstrap-4-responsive-wrapping-button-group -->
                    <div class="col col-md-3 d-flex justify-content-center align-items-center">
                        <div class="btn-group d-inline-flex d-md-none" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary data-bs-toggle="modal" data-bs-target="#periodicEdit""><i class="bi bi-list"></i> Edit Periodic Buy</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDeletePeriodic"><i class="bi bi-trash"></i> Cancel</button>
                        </div>
                        <div class="btn-group-vertical d-none d-md-inline-flex" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#periodicEdit"><i class="bi bi-list"></i> Edit Periodic Buy</button>
                            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDeletePeriodic"><i class="bi bi-trash"></i> Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php } ?>