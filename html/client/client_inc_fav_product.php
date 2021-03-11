<?php
function fav_card($id, $name, $description, $price, $unit)
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