<div id="all_credit_cards">
    <input type="hidden" id="selected_id" name="cc_id" value="-1">
    <input type="hidden" id="selected_i" value="-1">
    @php
        $i=0
    @endphp
    @foreach ($ccs as $cc)
        <div class="card mb-3" id="card:{{$i}}">
            <div class="row g-0">
                <div class="col-2">
                    <img src="https://via.placeholder.com/80x80" alt="Credit Card default image">
                </div>
                <div class="col-8 col-xl-9 col-sm-9" >
                    <div class="card-body">
                        <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard_{{$i}}"></a>
                        <h6 class="card-title" id="holder_prev:{{$i}}">{{$cc->holder}}</h6>
                        <p class="card-text" id="card_n_prev:{{$i}}">Visa car Ending in **{{substr($cc->card_n, -2)}}</p>
                    </div>
                </div>
                <div class="col-1">
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard_{{$i}}" > <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>
                </div>
            </div>
        </div>
        @include('partials.modals.edit_credit_card', ['cc' => $cc, 'i' => $i++])
    @endforeach
    
</div>
