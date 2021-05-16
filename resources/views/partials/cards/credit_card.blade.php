<div id="all_credit_cards">
    @php
        $i=0
    @endphp
    @foreach ($ccs as $cc)
        <div class="card mb-3">
            <div class="row g-0">
                <div class="col-2">
                    <img src="https://via.placeholder.com/80x80" alt="Credit Card default image">
                </div>
                <div class="col-8 col-xl-9 col-sm-9" >
                    <div class="card-body">
                        <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"></a>
                        <h6 class="card-title" id="holder_prev:{{$i}}">{{$cc->holder}}</h6>
                        <p class="card-text" id="card_n_prev:{{$i}}">Visa car Ending in **{{substr($cc->card_n, -2)}}</p>
                    </div>
                </div>
                <div class="col-1">
                    <a href="#" class="stretched-link" data-bs-toggle="modal" data-bs-target="#editCard"> <button type="button" class="simpleicon" id="simpleiconwhite">edit</button></a>
                </div>
            </div>
        </div>
        @include('partials.modals.edit_credit_card', ['cc' => $cc, 'i' => $i])
    @endforeach    
</div>
