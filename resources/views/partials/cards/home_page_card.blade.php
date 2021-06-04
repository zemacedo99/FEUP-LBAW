<script src={{ asset('js/homepage.js') }} defer> </script>

<div class="card customcard bg-white text-dark">
    <img src={{ asset($item->image) }} class="card-img" alt="{{ $item->name }}">
    <div class="card-img-overlay">
        <div class="row mb-5 me-1">

            @if (Auth::check() && app('App\Models\Client')::find(Auth::user()->id) != null)

                @php
                    $buttonId = 'product' . $item['id'];
                @endphp
                <button class="btn float-end text-end" id={{ $buttonId }}
                    onclick="favoriteAddRemove({{ $item . ',' . $buttonId }});">
                    @if ($item->favorite)
                        <i class="bi bi-suit-heart-fill"></i>
                    @else
                        <i class="bi bi-suit-heart"></i>
                    @endif

                </button>

            @else
                <div class="row my-3"></div>

            @endif

        </div>
        <a href="/items/{{ $item->id }}" class="unformatedLink">
            <div class="row my-4"></div>
            <div class="row my-2"></div>
            <div class="row my-3"></div>
            <div class="row mt-5">
                <div class="col">
                    @php
                        $width = 17;
                        $title = '';
                        if (strlen($item->name) > $width) {
                            $title = wordwrap($item->name, $width);
                            $title = substr($title, 0, strpos($title, "\n")) . '...';
                        } else {
                            $title = $item->name;
                        }
                    @endphp
                    <p class="card-title">{{ $title }}</p>
                </div>

                @if ($item->rating > 0)
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $item->rating) <div
                            class="col-1"><i class="bi bi-star-fill" style="color:
                            #d2d820;"></i></div>
                        @else
                            <div class="col-1"><i class="bi bi-star" style="color:
                            #d2d820;"></i></div> @endif
                    @endfor
                @endif

            </div>
        </a>
    </div>
    <div class="card-footer text-muted"> {{ $item->price }}€/{{ $item->unit }} </div>

</div>
