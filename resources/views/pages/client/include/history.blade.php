@include('partials.modals.add_modal',
            ['modalName'=>"CancelOrder",
            'title'=>"Cancelation Confirmation",
            'bodyText'=>"Are you sure you want to cancel this order?",
            'buttonPrimary'=>"Cancel",
            'buttonSecondary'=>"Dismiss",
            ]
         )

@include('partials.modals.review')

@foreach ($history as $item)
    @include('partials.cards.product_in_history',
            [
                'name' => $item["name"],
                'price' => $item["price"],
                'unit' => $item["unit"],
                'description' => $item["description"],
                'paid' => $item["pivot"]["price"],
                'image' => $item["image"],
                'type' => 'cancel'
            ])
@endforeach
