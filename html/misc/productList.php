<!DOCTYPE html>
<html>

<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../common/starStyle.css">

    <title>Title of the document</title>
</head>

<body>
    <!-- Optional JavaScript; choose one of the two! -->
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
        crossorigin="anonymous"></script>

    <div id="mainContainer" class="container-fluid">
        <div class="row">
            <nav id="filters" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <div id="storeProductSwitch" class="container border-bottom">
                        <input type="radio" class="btn-check" name="options" id="storesOption" autocomplete="off"
                            checked>
                        <label class="btn btn-secondary" for="storesOption">Stores</label>

                        <input type="radio" class="btn-check" name="options" id="productsOption" autocomplete="off">
                        <label class="btn btn-secondary" for="productsOption">Products</label>
                    </div>
                    <div id="Category" class="container border-bottom">
                        <b>Category</b>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="food">
                            <label class="form-check-label" for="food">
                                food
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="fertilizer">
                            <label class="form-check-label" for="fertilizer">
                                fertilizer
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="pesticides">
                            <label class="form-check-label" for="pesticides">
                                pesticides
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="biologic">
                            <label class="form-check-label" for="biologic">
                                biologic
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="gardening">
                            <label class="form-check-label" for="gardening">
                                gardening
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="tools">
                            <label class="form-check-label" for="tools">
                                tools
                            </label>
                        </div>
                    </div>
                    <div id="PriceRange" class="container border-bottom">
                        <b>Price Range</b>
                        <input type="number" class="form-control" placeholder="min">
                        <input type="number" class="form-control" placeholder="max">
                    </div>
                    <div id="ReviewClassification" class="container border-bottom">
                        <b>Review Classification</b>
                        Min: <div class="rating"> <input type="radio" name="ratingmin" value="5" id="5min"><label
                                for="5min">☆</label> <input type="radio" name="ratingmin" value="4" id="4min"><label
                                for="4min">☆</label> <input type="radio" name="ratingmin" value="3" id="3min"><label
                                for="3min">☆</label> <input type="radio" name="ratingmin" value="2" id="2min"><label
                                for="2min">☆</label> <input type="radio" name="ratingmin" value="1" id="1min"><label
                                for="1min">☆</label>
                        </div>
                        
                        Max: <div class="rating"> <input type="radio" name="ratingmax" value="5" id="5max"><label
                                for="5max">☆</label> <input type="radio" name="ratingmax" value="4" id="4max"><label
                                for="4max">☆</label> <input type="radio" name="ratingmax" value="3" id="3max"><label
                                for="3max">☆</label> <input type="radio" name="ratingmax" value="2" id="2max"><label
                                for="2max">☆</label> <input type="radio" name="ratingmax" value="1" id="1max"><label
                                for="1max">☆</label>
                        </div>

                    </div>

                    <div id="Country" class="container border-bottom">
                        <b>Country</b>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Poland
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Jamaica
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Portugal
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Canada
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Congo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                China
                            </label>
                        </div>
                    </div>
                    <div id="MaxDistance" class="container border-bottom">
                        <b>Max Distance</b>
                        <!--https://seiyria.com/bootstrap-slider/-->
                        <input id="distance" type="range" class="span2" value="0" data-slider-min="0"
                            data-slider-max="1000" data-slider-step="5">
                        <input name="MaxDistanceRepresentation" type="number" class="form-control disable"
                            placeholder="0">

                    </div>
                </div>


            </nav>

            <div class="col-md-8 ms-sm-auto col-lg-8 ">

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="https://via.placeholder.com/150x150" alt="...">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Vermelhas</h4>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div>
                                        <h5 class="card-title ">3,50€/kg</h5>
                                        <div class="rating justify-content-md-end"> <input type="radio" name="ratinga"
                                                value="5" id="5a"><label for="5a">☆</label> <input type="radio"
                                                name="ratinga" value="4" id="4a"><label for="4a">☆</label> <input
                                                type="radio" name="ratinga" value="3" id="3a"><label for="3a">☆</label>
                                            <input type="radio" name="ratinga" value="2" id="2a"><label
                                                for="2a">☆</label> <input type="radio" name="ratinga" value="1"
                                                id="1a"><label for="1a">☆</label>
                                        </div>
                                    </div>
                                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                                        <i class=text-muted>Apple Inc.
                                            California, USA</i>
                                    </div>
                                </div>

                                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                                    Este é outro texto mega interessante sobre maças vermelhas, boas para comer
                                    cruas ou
                                    assadas,
                                    possuem tamanhos variados, mas parece que a descrição não cabe aqui então v..
                                </p>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="https://via.placeholder.com/150x150" alt="...">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Verdes</h4>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div>
                                        <h5 class="card-title ">4,50€/kg</h5>
                                        <div class="rating justify-content-md-end"> <input type="radio" name="ratingb"
                                                value="5" id="5b"><label for="5b">☆</label> <input type="radio"
                                                name="ratingb" value="4" id="4b"><label for="4b">☆</label> <input
                                                type="radio" name="ratingb" value="3" id="3b"><label for="3b">☆</label>
                                            <input type="radio" name="ratingb" value="2" id="2b"><label
                                                for="2b">☆</label> <input type="radio" name="ratingb" value="1"
                                                id="1b"><label for="1b">☆</label>
                                        </div>
                                    </div>
                                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                                        <i class=text-muted>Apple Inc.
                                            California, USA</i>
                                    </div>
                                </div>

                                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                                    Mesmo interessante este texto sobre maças que o fornecedor for generoso o suficiente
                                    de disponiblizar a dar alguma informação sobre o produto
                                </p>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="https://via.placeholder.com/150x150" alt="...">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maças Azuis</h4>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div>
                                        <h5 class="card-title ">7,80€/kg</h5>
                                        <div class="rating justify-content-md-end"> <input type="radio" name="ratingc"
                                                value="5" id="5c"><label for="5c">☆</label> <input type="radio"
                                                name="ratingc" value="4" id="4c"><label for="4c">☆</label> <input
                                                type="radio" name="ratingc" value="3" id="3c"><label for="3c">☆</label>
                                            <input type="radio" name="ratingc" value="2" id="2c"><label
                                                for="2c">☆</label> <input type="radio" name="ratingc" value="1"
                                                id="1c"><label for="1c">☆</label>
                                        </div>
                                    </div>
                                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                                        <i class=text-muted>AppleNotInc.
                                            Felgueiras,
                                            Portugal</i>
                                    </div>
                                </div>

                                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                                    Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente
                                    tóxico as nossas maças ficam com uma bela cor azul fluorescente.
                                </p>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="https://via.placeholder.com/150x150" alt="...">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maço</h4>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div>
                                        <h5 class="card-title ">10€/un</h5>
                                        <div class="rating justify-content-md-end"> <input type="radio" name="ratingd"
                                                value="5" id="5d"><label for="5d">☆</label> <input type="radio"
                                                name="ratingd" value="4" id="4d"><label for="4d">☆</label> <input
                                                type="radio" name="ratingd" value="3" id="3d"><label for="3d">☆</label>
                                            <input type="radio" name="ratingd" value="2" id="2d"><label
                                                for="2d">☆</label> <input type="radio" name="ratingd" value="1"
                                                id="1d"><label for="1d">☆</label>
                                        </div>
                                    </div>
                                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                                        <i class=text-muted>Martelos Machado
                                            Vila Nova de Famalicão,
                                            Portugal</i>
                                    </div>
                                </div>

                                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                                    Martelo/maço de madeira com cabo em madeira de pinho e resistência a vibrações
                                </p>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-4 col-md-3 col-lg-2 col-xl-2">
                            <img src="https://via.placeholder.com/150x150" alt="...">
                        </div>
                        <div class="col-8 col-md-9 col-lg-10 col-xl-10">
                            <div class="card-body">
                                <div class="d-flex justify-content-between justify-content-md-start">
                                    <h4 class="card-title">Maçaroca</h4>
                                    <i class="bi bi-cart-plus ps-md-4"></i>
                                </div>
                                <div class="row row-cols-1 row-cols-md-2">
                                    <div>
                                        <h5 class="card-title ">2€/kg</h5>
                                        <div class="rating justify-content-md-end"> <input type="radio" name="ratinge"
                                                value="5" id="5e"><label for="5e">☆</label> <input type="radio"
                                                name="ratinge" value="4" id="4e"><label for="4e">☆</label> <input
                                                type="radio" name="ratinge" value="3" id="3e"><label for="3e">☆</label>
                                            <input type="radio" name="ratinge" value="2" id="2e"><label
                                                for="2e">☆</label> <input type="radio" name="ratinge" value="1"
                                                id="1e"><label for="1e">☆</label>
                                        </div>
                                    </div>
                                    <div class="text-center order-md-2 col-md-3 col-lg-3">
                                        <i class=text-muted>MilhoGalinheiro
                                            Ponta Delgada,
                                            Portugal</i>
                                    </div>
                                </div>

                                <p class="card-text text-truncate d-none d-md-block order-md-1 col-md-9 col-lg-9">
                                    Maças azuis? Sim caro cliente, maças azuis. Após um tratamento químico altamente
                                    tóxico as nossas maças ficam com uma bela cor azul fluorescente.
                                </p>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-1 ms-sm-auto col-lg-2 px-md-1">
                <select class="form-select" aria-label="Relevance">
                    <option selected>Order by:</option>
                    <option value="Price Up">Price Up</option>
                    <option value="Price Down">Price Down</option>
                    <option value="Review Up">Review Up</option>
                    <option value="Review Down">Review Down</option>
                    <option value="Relevance">Relevance</option>
                </select>
            </div>
        </div>
    </div>
</body>

</html>