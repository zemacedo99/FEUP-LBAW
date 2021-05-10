@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-md-10">
            <img class="img-fluid" src="{{ asset('storage/garden_remake.jpg') }}" alt="Photo of a garden" height="400px">
        </div>
    </div>

    <?php
        product_row("Almost Sold Out", "clock",$items["almostSoldOut"]);
    ?>

    <?php
        product_row("Hot", "sun", $items["hot"]);
    ?>

    <?php
        product_row("New", "newspaper", $items["new"]);
    ?>

    <div class="row my-5">
        <div class="col"></div>
        <div class="col-6 col-md-4 col-lg-3 text-end">
            <a href="/misc/productList.php" class="link-secondary">See all products<i class="bi bi-arrow-right-short"></i></a>
        </div>
    </div>

</div>


<?php
function homepage_card($item)
{
?>

    <a href=/item/{{$item->id}} class="card customcard bg-white text-dark">
       
        <img src={{$item->images[0][0]->path}} class="card-img" alt={{$item->name}}>
        <div class="card-img-overlay">

            <div class="row mb-5 me-1">
                <div class="col"></div>
                <div class="col-1"><i class="bi bi-suit-heart"></i></div>
            </div>
            <div class="row my-5"></div>
            <div class="row my-2"></div>
            <div class="row my-3"></div>
            <div class="row mt-5">
                <div class="col">
                    @php
                    $width=17;
                    $title="";
                    if (strlen($item->name) > $width) 
                    {
                        $title = wordwrap($item->name, $width);
                        $title = substr($title, 0, strpos($title, "\n"))."...";
                    }else{
                        $title=$item->name;
                    }
                    @endphp
                    <p class="card-title">{{$title}}</p>
                </div>

                @if ($item->rating>0)
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i<=$item->rating)
                            <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        @else
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>
                        @endif
                    
                    @endfor
                @endif
            
                
            
            </div>
        </div>
        <div class="card-footer text-muted">{{$item->price}}€/{{$item->unit[0]->type}}</div>
    </a>

<?php
}

function product_row($name, $icon, $item){

?>
    <div class="row mt-5 ms-4 ms-md-0">
        <div class="col-6 text-start">
            <p><i class="bi bi-<?php echo $icon?>"></i> <?php echo $name ?></p>
        </div>
    </div>

    
    <div class="row justify-content-center">
        @for ($i = 0; $i < 4; $i++)
            <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
                <?php  homepage_card($item[$i]); ?>
            </div>
        @endfor
            
        
    </div>
<?php
}

?>

@endsection
