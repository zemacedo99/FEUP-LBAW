<?php
function orderSummary($n)
{
?>
    <div class="row" style='border-bottom:2px solid black;'>
        <div class="col-6">
            <h3 style='text-align:left;'>Order Summary</h3>
        </div>
        <div class="col-6">
            <h3 style='text-align:right;'><?= $n ?> items in your cart</h3>
        </div>
    </div>
<?php
}
?>


<?php
function cartProduct($name, $total, $price)
{
?>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <div class="card m-3">
            <div class="row">
                <div class="col-lg-4">
                    <img src="../images/<?= $name ?>.jpg" class="rounded mx-auto d-block" alt=<?= $name ?> style="margin-left:auto; margin-right:auto;width:8em;height:8em;">
                </div>
                <div class="col-lg-8">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3"><?= $name ?></h4>


                        <div class="row text-center">
                            <div class="col-xl-4">
                                <h5 class="card-text text-muted">Total: <?= $total ?></h5>
                            </div>

                            <div class="col-xl-4">
                                <button type="button" class="simpleicon" id="simpleiconwhite">add_circle_outline</button>
                                <button type="button" class="simpleicon" id="simpleiconwhite"> remove_circle_outline</button>
                            </div>

                            <div class="col-xl-4">
                                <h5 class="card-text"><?= $price ?>€</h5>
                            </div>

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
function cuponCard($name, $discount, $date)
{
?>
    <!-- <div class="col-lg-12 col-10 mx-auto"> -->
    <div class="col-lg-4 col-10 mx-auto">
        <div class="p-3">
            <div class="card">

                <?= cuponImage("cupon") ?>

                <div class="card-img-overlay">
                    <div class="text-center">
                        <br><br>
                        <h5 class="card-title"><?= $name ?></h5>
                        <p class="card-text"><?= $discount ?>%</p>
                    </div>
                </div>
                <div class="card-footer">
                    <small class="text-muted">Valid until <?= $date ?></small>
                </div>
            </div>
        </div>
    </div>


<?php
}
?>


<?php
function cuponImage($done)
{
?>
    <div class="col">
        <img src="../images/<?= $done ?>.jpg" class="img-fluid" alt="<?= $done ?>" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
    </div>
<?php
}
?>


<?php
function orderTotal($n)
{
?>
    <div class="col-12">

        <!-- <div class="col-6">
            <div class="d-flex justify-content-start">
                <h4 style='text-align:center;'>Total </h4>
            </div>
        </div>

        <div class="col-6">
            <div class="d-flex justify-content-end">
                <h4 style='text-align:center;'><?= $n ?>€ </h4>
            </div>
        </div> -->

        <h4 style='text-align:center;'>Total: <?= $n ?> €</h4>
        <div class="row mb-3"></div>


    </div>
<?php
}
?>

<?php
function paymentCard($holder, $number)
{
?>
    <!-- <div class="card mb-3">
        <div class="row g-0">
            <div class="col-2 col-md-2">
                <img src="https://via.placeholder.com/80x80" alt="...">
            </div>
            <div class="col-8 col-md-9">
                <div class="card-body">
                    <h6 class="card-title"><?= $holder ?></h6>
                    <p class="card-text">Visa car Ending in **<?= $number ?> </p>
                </div>
            </div>
            <div class="col-2 col-md-1">
                <a href="edit_card.php"> <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>
            </div>
        </div>
    </div> -->


    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-2">
                <img src="https://via.placeholder.com/80x80" alt="...">
            </div>
            <div class="col-8  col-xl-9 col-sm-9">
                <div class="card-body">
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"></a>
                    <h6 class="card-title">Card Holder</h6>
                    <p class="card-text">Visa car Ending in **69</p>
                </div>
            </div>
            <div class="col-1">
                <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"> <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>

            </div>
        </div>
    </div>


    <?= paymentCardEditModal() ?>

<?php
}
?>


<?php
function paymentCardEditModal()
{
?>
    <div class="modal fade" id="editCard" tabindex="-1" aria-labelledby="editCardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardLabel">Edit Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="floatingInput" placeholder="**** **** **** ****">
                            <label for="floatingInput">Card number</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="month" class="form-control" id="floatingFirstName" placeholder="Valid until">
                                <label for="floatingFirstName">Valid until</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="floatingLastName" placeholder="CVV">
                                <label for="floatingLastName">CVV</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="floatingInput" placeholder="Your name and surname">
                            <label for="floatingInput">Card holder</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary btn-sm"><i class="bi bi-trash"></i> Delete this card</button>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Edit Card</button>
                </div>
            </div>
        </div>
    </div>


<?php
}
?>


<?php
function paymentCardAddModal()
{
?>
    <div class="modal fade" id="addCard" tabindex="-1" aria-labelledby="addCardLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCardLabel">Add Card</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="floatingInput" placeholder="**** **** **** ****">
                            <label for="floatingInput">Card number</label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <div class="form-floating">
                                <input type="month" class="form-control" id="floatingFirstName" placeholder="Valid until">
                                <label for="floatingFirstName">Valid until</label>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-floating">
                                <input type="number" class="form-control" id="floatingLastName" placeholder="CVV">
                                <label for="floatingLastName">CVV</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="floatingInput" placeholder="Your name and surname">
                            <label for="floatingInput">Card holder</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="form-check form-switch">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Save data for future purchases</label>
                            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Add Card</button>
                </div>
            </div>
        </div>
    </div>


<?php
}
?>




<?php
function addNewCard()
{
?>
    <div class="card mb-3 d-flex justify-content-center align-items-center" style="height: 60px;">
        <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#addCard"></a>
        <p class="card-text">Add new Card <i class="bi bi-plus"></i></p>
    </div>

    <?= paymentCardAddModal() ?>
<?php
}
?>