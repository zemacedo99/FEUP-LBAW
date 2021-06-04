<div class="modal fade" id="modalReview" tabindex="-1" aria-labelledby="modalReviewLabel" aria-hidden="true">
    <div class="modal-dialog">
            <input type="hidden" id="product_id_review">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalReviewLabel">Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row ms-1" id="product_name"></div>
                <div class="row mb-1">
                    <div class="rating d-flex justify-content-end mb-2">
                        <input type="hidden" id="rating">

                        <input type="radio" name="rating" value="5" id="5" onclick="getElementById('rating').value = 5">
                        <label for="5" >☆</label>
                        <input type="radio" name="rating" value="4" id="4" onclick="getElementById('rating').value = 4">
                        <label for="4">☆</label>
                        <input type="radio" name="rating" value="3" id="3" onclick="getElementById('rating').value = 3">
                        <label for="3">☆</label>
                        <input type="radio" name="rating" value="2" id="2" onclick="getElementById('rating').value = 2">
                        <label for="2">☆</label>
                        <input type="radio" name="rating" value="1" id="1" onclick="getElementById('rating').value = 1">
                        <label for="1">☆</label>
                    </div>
                    <div class="row">
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="comment" style="height: 100px"></textarea>
                            <label for="comment" class="ps-4 pt-2">Comment</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="deleteReview">Delete review</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="ConfirmReviewBtn">Confirm</button>
                </div>
            </div>
        </div>
    </div>
</div>
