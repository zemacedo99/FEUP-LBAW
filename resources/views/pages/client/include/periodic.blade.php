@include('partials.modals.add_modal',
            ['modalName'=>"DeletePeriodic",
            'title'=>"Confirmation",
            'bodyText'=>"Are you sure you want to cancel this periodic purchase?",
            'buttonPrimary'=>"Delete",
            'buttonSecondary'=>"Cancel"
            ]
         )

@include('partials.modals.periodic_buy')

@for ($i = 0; $i < 10; $i++)
    @include('partials.cards.product_in_periodic',
            [
                'name' => 'Test',
                'price' => '5',
                'unit' => 'Kg',
                'description' => 'Uma descricao',
                'paying' => '5',
                'periodicity' => 'Weekly on Mondays'
            ])
@endfor
