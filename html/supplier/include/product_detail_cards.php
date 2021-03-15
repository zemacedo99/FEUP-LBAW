<?php
function productListCard($id, $name, $price, $unit, $supplier, $description)
{ ?>
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                <img class="img-fluid" src="https://via.placeholder.com/150x150" alt="...">
            </div>
            <div class="col-8 col-md-9 col-lg-10">
                <div class="card-body">
                    <div class="d-flex justify-content-between ">
                        <h4 class="card-title"><?=$name?></h4>
                        <i class="bi bi-cart-plus ps-md-4"></i>
                    </div>
                    <div class="row row-cols-md-2">
                        <div class="col-10">
                            <h5 class="card-title "><?=$price?>€/<?=$unit?></h5>
                            <!-- Isto tem de ser estático -->
                            <div class="rating justify-content-end"> 
                                <input type="radio" name="ratinga" value="5" id="5a"><label for="5a">☆</label> 
                                <input type="radio" name="ratinga" value="4" id="4a"><label for="4a">☆</label> 
                                <input type="radio" name="ratinga" value="3" id="3a"><label for="3a">☆</label>
                                <input type="radio" name="ratinga" value="2" id="2a"><label for="2a">☆</label>
                                <input type="radio" name="ratinga" value="1" id="1a"><label for="1a">☆</label>
                            </div>
                        </div>
                        <div class="col d-none d-md-block d-lg-block text-end sm-5 ">
                            <i class=text-muted><?=$supplier?></i>
                        </div>
                    </div>

                    <div class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9"><?=$description?></div>

                </div>
            </div>
        </div>
    </div>
<?php } ?>
