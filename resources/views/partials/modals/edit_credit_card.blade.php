<div class="modal fade" id="editCard_{{$i}}" tabindex="-1" aria-labelledby="editCardLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCardLabel">Edit Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" value="{{$cc->id}}" id="cc_id:{{$i}}" >
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="card_number:{{$i}}" name="card_number" value="{{$cc->card_n}}">
                        <label for="card_number">Card number</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating">
                            <input type="month" class="form-control" id="valid_until:{{$i}}" name="valid_until" value ="{{$cc->expiration}}">
                            <label for="valid_until">Valid until</label>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="cvv:{{$i}}" name="cvv" placeholder="CVV" value ="{{$cc->cvv}}">
                            <label for="cvv">CVV</label>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="holder_name:{{$i}}" name="holder_name" value ="{{$cc->holder}}">
                        <label for="holder_name_e">Card holder</label>
                    </div>
                </div>
                
                <div class="d-flex justify-content-center">
                    <button type="button" id="delete:{{$i}}" class="btn btn-danger btn-sm delete"  data-bs-dismiss="modal"><i class="bi bi-trash"></i> Delete this card</button>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="select:{{$i}}" class="btn btn-primary select" data-bs-dismiss="modal">Select Card</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="edit:{{$i}}"  data-bs-dismiss="modal" class="btn btn-primary edit">Edit Card</button>
            </div>
        </div>
    </div>
</div>