<div class="row mt-5 ms-4 ms-md-0">
    <div class="col-6 text-start">
        <p><i class="bi bi-{{ $icon }}"></i>{{ $name }}</p>
    </div>
</div>

<div class="row justify-content-center">
    @for ($i = 0; $i < 4; $i++)
        <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
            @include('partials.cards.home_page_card',['item'=> $items[$i]])
        </div>
    @endfor
</div>
