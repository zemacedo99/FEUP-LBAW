<?php
include_once '../common/extras.php';
include_once 'supplier_inc_bundle_and_cupon.php';
pageHeader("MyGarden - Bundles & Cupons");
navbar();
?>

<div class="container">
    <div class="row m-4"></div>

    <div class="row mb-3">

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="bundles-tab" data-bs-toggle="tab" data-bs-target="#bundles" type="button" role="tab" aria-controls="bundles" aria-selected="true">Bundles</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cupons-tab" data-bs-toggle="tab" data-bs-target="#cupons" type="button" role="tab" aria-controls="cupons" aria-selected="false">Cupons</button>
            </li>
            <li class="nav-item" role="presentation">
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="bundles" role="tabpanel" aria-labelledby="bundles-tab">

                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>


                <div class="row">
                    <div class="col"></div>
                    <div class="col-8">
                        <div class="d-flex justify-content-center">
                            <button type="button" class="btn btn-primary"> Add Bundle</button>
                        </div>

                        <div class="row mt-3"></div>
                        <div class="row mt-3"></div>

                        <div class="row row-cols-1 row-cols-md-2 g-4">


                            <?php
                            for ($i = 0; $i < 5; $i++) {
                                bundleCard(
                                    "Winter Bundle",
                                    30.50,
                                    3
                                );
                            }

                            ?>
                        </div>

                    </div>
                    <div class="col"></div>
                </div>

            </div>

            <div class="tab-pane fade" id="cupons" role="tabpanel" aria-labelledby="cupons-tab">
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="d-flex justify-content-center">
                    <button type="button" class="btn btn-primary"> Add Cupon</button>
                </div>
                <div class="row mt-3"></div>
                <div class="row mt-3"></div>
                <div class="row row-cols-1 row-cols-md-2 g-4">

                    <?php
                    cuponCard(
                        "SUMMER 2021",
                        10,
                        "2/5/2021",
                        "WINTER2021",
                        "cupon"
                    );
                    for ($i = 0; $i < 3; $i++) {
                        cuponCard(
                            "SUMMER 2020",
                            10,
                            "2/5/2020",
                            "WINTER2020",
                            "cupon_done"
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
footer();
?>