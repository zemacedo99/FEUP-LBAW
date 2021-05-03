@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-12 col-md-10">
            <img class="img-fluid" src="{{ asset('storage/garden_remake.jpg') }}" alt="Photo of a garden" height="400px">
        </div>
    </div>

    <?php
        product_row("Almost Sold Out", "clock");
    ?>

    <?php
        product_row("Hot", "sun");
    ?>

    <?php
        product_row("New", "newspaper");
    ?>

    <div class="row my-5">
        <div class="col"></div>
        <div class="col-6 col-md-4 col-lg-3 text-end">
            <a href="/misc/productList.php" class="link-secondary">See all products<i class="bi bi-arrow-right-short"></i></a>
        </div>
    </div>

</div>


<?php
function homepage_card()
{
?>

    <div class="card customcard bg-white text-dark">
        <img src="{{ asset('images/banana.jpg') }}" class="card-img" alt="A banana">
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
                    <p class="card-title">Bananas</p>
                </div>

                <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

            </div>
        </div>
        <div class="card-footer text-muted">1.20€/Kg</div>
    </div>

<?php
}

function product_row($name, $icon){

?>
    <div class="row mt-5 ms-4 ms-md-0">
        <div class="col-6 text-start">
            <p><i class="bi bi-<?php echo $icon?>"></i> <?php echo $name ?></p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
            <?php  homepage_card(); ?>
        </div>

        <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
            <?php  homepage_card(); ?>
        </div>

        <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
            <?php  homepage_card(); ?>
        </div>

        <div class="col-9 col-sm-6 col-md-4 col-lg-3 mb-4 mb-md-0">
            <?php  homepage_card(); ?>
        </div>
    </div>
<?php
}

?>

@endsection
