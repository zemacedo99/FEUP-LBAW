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
    @include('partials.cards.product_in_periodic',
            [
                'name' => $per['name'],
                'price' => $per['price'],
                'unit' => $per['unit'],
                'description' => $per['description'],
                'paying' => $per['pivot']['price'],
                'periodicity' => $per['type']
            ])
@endforeach
