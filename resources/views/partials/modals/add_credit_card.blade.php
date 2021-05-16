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
                        <input class="form-control" id="card_number" name="card_number" placeholder="Card Number">
                        <label for="card_number">Card number</label>
                        <small id="card_number_alert" class="text-danger"></small>
                    </div>
                    
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="valid_until" name="valid_until" placeholder="Valid until">
                            <label for="valid_until">Valid until</label>
                        </div>
                        <small id="valid_until_alert" class="text-danger"></small>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="cvv" name="cvv" placeholder="CVV">
                            <label for="cvv">CVV</label>
                        </div>
                        <small id="cvv_alert" class="text-danger"></small>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="holder_name" name="holder_name" placeholder="Card Holder">
                        <label for="holder_name">Card Holder</label>
                        <small id="holder_name_alert" class="text-danger"></small>
                    </div>
                    
                </div>

                <div class="d-flex justify-content-center">
                    <div class="form-check form-switch">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Save data for future purchases</label>
                        <input class="form-check-input" type="checkbox" id="save_credit_card">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal" id="add_cc" >Add Card</button>
            </div>
        </div>
    </div>
</div>