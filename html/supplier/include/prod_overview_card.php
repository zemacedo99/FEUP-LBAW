<?php
/**
 * Creates a card for the product overview in the supplier
 */
function suppOverviewCard($id, $name, $price, $unit, $description)
{
?>
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