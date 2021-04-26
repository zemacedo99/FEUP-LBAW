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