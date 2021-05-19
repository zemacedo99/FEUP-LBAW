@include('partials.modals.add_modal',
            ['modalName'=>"DeletePeriodic",
            'title'=>"Confirmation",
            'bodyText'=>"Are you sure you want to cancel this periodic purchase?",
            'buttonPrimary'=>"Delete",
            'buttonSecondary'=>"Cancel"
            ]
         )

@include('partials.modals.periodic_buy')

@foreach($periodic as $per)
    @include('partials.cards.product_in_periodic',['item' => $per])
@endforeach
