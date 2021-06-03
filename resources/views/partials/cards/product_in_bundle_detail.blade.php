<div class="row">

    <div class="col-6 text-center">
        <img src="{{ asset($product->images->path) }}" class="img-fluid img-thumbnail"
            style=" margin-left:auto; margin-right:auto;width:104px;height:142px;">
    </div>
    <div class="col-6">
        <h6 class="card-title">{{ $product->name }}</h6>
        <p class="card-text">Total: {{ $product->quantity }}</p>
    </div>
</div>
