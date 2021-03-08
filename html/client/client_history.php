<?php
include_once '../common/modal.php';
addModal(
    "CancelOrder",
    "Cancelation Confirmation",
    "Are you sure you want to cancel this order?",
    "Cancel",
    "Dismiss"
);
?>

<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReviewLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">Titulo</div>
                <div class="row">
                    <div class="rating"> <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>

                    </div>
                    <div class="row">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Comments</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img src="https://via.placeholder.com/150x150" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title text-truncate">Maças Verdes</h4>
                    <i class="bi bi-exclamation-triangle ps-md-4"></i>
                </div>
                <h6 class="card-subtitle text-muted">4,50€/kg</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                        Mesmo interessante este texto sobre maças que o fornecedor foi generoso o suficiente de disponiblizar a dar alguma informação sobre o produto
                    </p>
                    <h4 class="card-title text-end text-md-start order-md-3">3,33€</h4>
                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                        <button type="button" class="btn btn-secondary text-truncate" data-bs-toggle="modal" data-bs-target="#modalCancelOrder"><i class="bi bi-x"></i> Cancel Order</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img src="https://via.placeholder.com/150x150" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title text-truncate">Maças Vermelhas</h4>
                    <i class="bi bi-cart-plus ps-md-4"></i>
                </div>
                <h6 class="card-subtitle text-muted">3,50€/kg</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                        Este é outro texto mega interessante sobre maças vermelhas, boas para comer cruas ou assadas, possuem tamanhos variados, mas parece que a descrição não cabe aqui então vou terminar.
                    </p>
                    <h4 class="card-title text-end text-md-start order-md-3">2,50€</h4>
                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                        <button type="button" class="btn btn-primary text-truncate" data-bs-toggle="modal" data-bs-target="#modalReview"><i class="bi bi-list"></i> Edit Review</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="row g-0">
        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
            <img src="https://via.placeholder.com/150x150" alt="...">
        </div>
        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
            <div class="card-body">
                <div class="d-flex justify-content-between justify-content-md-start">
                    <h4 class="card-title text-truncate">Maças Azuis</h4>
                    <i class="bi bi-cart-plus ps-md-4"></i>
                </div>
                <h6 class="card-subtitle text-muted">7,80€/kg</h6>

                <div class="row row-cols-1 row-cols-md-2">
                    <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                        Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente tóxico as nossas maças ficam com uma bela cor azul fluorescente.
                    </p>
                    <h4 class="card-title text-end text-md-start order-md-3">4,13€</h4>
                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                        <button type="button" class="btn btn-success  text-truncate"><i class="bi bi-plus"></i> Leave a Review</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>