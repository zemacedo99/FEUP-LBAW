<div class="col">
    <div class="card">
        <img src="{{ asset($item->image) }}" class="card-img-top" alt="...">
        <div class="card-img-overlay d-flex justify-content-end overdiv">

            <label for="favorite{{ $item->id }}" class="favorite-checkbox">
                <input type="checkbox" checked id="favorite{{ $item->id }}" />
                <i class="bi bi-heart"></i>
                <i class="bi bi-heart-fill"></i>
            </label>

        </div>
        <div class="card-body">
            <h5 class="card-title">{{ $item->name }}</h5>
            <p class="card-text d-none d-md-block text-truncate">{{ $item->description }}</p>
            <h6 class="card-title text-end text-md-start order-md-3">{{ $item->price }}€/{{ $item->unit }}</h6>
            <a href="{{ url("/item/$item->id") }}" class="stretched-link"></a>
        </div>
    </div>
</div>
