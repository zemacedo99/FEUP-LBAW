<div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 row-cols-xxl-6 g-4">
    @foreach($favorites as $fav)
        @include('partials.cards.product_in_favorites', ['item' => $fav])
    @endforeach
</div>
