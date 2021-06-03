<div class="modal fade" id="modal{{ $modalName }}" tabindex="-1" aria-labelledby="modal{{ $modalName }}Label" aria-hidden="true">
    <div class="modal-dialog">
            <input type="hidden" id="product_id_modal">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal{{ $modalName }}Label">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $bodyText }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ $buttonSecondary }}</button>
                <button type="button" class="btn btn-primary" id="YesButtonModal">{{ $buttonPrimary }}</button>
            </div>
        </div>
    </div>
</div>
