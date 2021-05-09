@include('partials.modals.add_modal',
            ['modalName'=>"CancelOrder",
            'title'=>"Cancelation Confirmation",
            'bodyText'=>"Are you sure you want to cancel this order?",
            'buttonPrimary'=>"Cancel",
            'buttonSecondary'=>"Dismiss",
            ]
         )

@include('partials.modals.review')

@foreach ($items as $item)
    @include('partials.cards.product_in_history',
            [
                'name' => $item["name"],
                'price' => $item["price"],
                'unit' => $item["type"],
                'description' => $item["description"],
                'paid' => $item["pivot"]["price"],
                'type' => 'cancel'
            ])
@endforeach

{{--
@for ($i = 0; $i < 10; $i++)
    @include('partials.cards.product_in_history',
            [
                'name' => 'Test',
                'price' => '5',
                'unit' => 'Kg',
                'description' => 'Uma descricao',
                'paid' => '5',
                'type' => 'cancel'
            ])
@endfor
--}}

