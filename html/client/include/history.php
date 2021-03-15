<?php
addModal(
    "CancelOrder",
    "Cancelation Confirmation",
    "Are you sure you want to cancel this order?",
    "Cancel",
    "Dismiss"
);
?>

<!-- WIP: Modal da Review -->
<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReviewLabel">Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ms-1">Maças Verdes</div>
                <div class="row mb-1">
                    <div class="rating d-flex justify-content-end mb-2">
                        <input type="radio" name="rating" value="5" id="5">
                        <label for="5">☆</label>
                        <input type="radio" name="rating" value="4" id="4">
                        <label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3">
                        <label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2">
                        <label for="2">☆</label>
                        <input type="radio" name="rating" value="1" id="1">
                        <label for="1">☆</label>
                    </div>
                    <div class="row">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2" class="ps-4 pt-2">Comment</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
historyProduct(
    1,
    "Maças Verdes",
    "4,50",
    "kg",
    "Mesmo interessante este texto sobre maças que o fornecedor foi generoso o suficiente de disponiblizar a dar alguma informação sobre o produto",
    "3,33",
    "cancel"
);

historyProduct(
    1,
    "Maças Vermelhas",
    "3,50",
    "kg",
    "Este é outro texto mega interessante sobre maças vermelhas, boas para comer cruas ou assadas, possuem tamanhos variados, mas parece que a descrição não cabe aqui então vou terminar.",
    "2,50",
    "edit"
);

historyProduct(
    1,
    "Maças Azuis",
    "7,80",
    "kg",
    "Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente tóxico as nossas maças ficam com uma bela cor azul fluorescente.",
    "4,13",
    "leave"
);

?>