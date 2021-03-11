<?php
include_once '../common/extras.php';
include_once 'supplier_inc_all_products.php';
pageHeader("MyGarden - Products");
navbar();
?>

<div class="container">

    <?php
    perfilSupplier(
        "img_avatar.png",
        "Quinta do Bill"
    );
    ?>

    <h3> All Products </h3>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <!-- List of all products that a store have -->
    <div class="row row-cols-1 row-cols-sm-2 g-4">

        <?php
        for ($i = 0; $i < 5; $i++) {
            productCard(
                "bananas",
                "7,80",
                "kg",
                "Na Quinta do Bill tens bananas que te fazem voar, voar, voar."
            );
        }
        for ($i = 0; $i < 5; $i++) {
            productCard(
                "batata-amarela",
                "7,80",
                "kg",
                "Na Quinta do Bill tens bananas que te fazem voar, voar, voar."
            );
        }
        ?>

    </div>

</div>

<?php
footer();
?>