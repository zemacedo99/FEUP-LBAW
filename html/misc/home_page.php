<!DOCTYPE html>
<html class="h-100">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="homepage.css">
  
  <!-- FavIcon -->
  <link rel="shortcut icon" href="../images/favicon.ico" type="image/png">
  <link rel="icon" href="../images/favicon.ico" type="image/png">

  <link rel="stylesheet" type="text/css" href="../style.css">
  <script src="../client_profile.js" defer></script>

  <!-- Material icons-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  
  <title>MyGarden</title>
</head>

<body class="h-100 d-flex flex-column">
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>


<?php
include '../common/navbar.php';
?>

<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center"> <img src="../images/garden.jpg" alt="Photo of a garden" width="650px" height="400px"></div>
    </div>
    <div class="row mt-5">
        <div class="col-6 text-start">
            <p><i class="bi bi-clock"></i> Almost Sold out</p>
        </div>
    </div>

    <!-- Almost sold out Row -->
    <div class="row">
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/banana.jpg" class="card-img" alt="A banana">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
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
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/anona.jpg" class="card-img" alt="A custard apple">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Custard Apple</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">2.20€/Kg</div>
            </div>
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/green_apple.jpg" class="card-img" alt="A green apple">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Green apples</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">1.00€/Kg</div>
            </div>
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/red_apple.jpg" class="card-img" alt="A red apple">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Red apple</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">1.40€/Kg</div>
            </div>
        </div>
    </div>

    <!-- Hot -->
    <div class="row mt-5">
        <div class="col-6 text-start">
            <p><i class="bi bi-sun"></i> Hot</p>
        </div>
    </div>

    <div class="row">
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/banana.jpg" class="card-img" alt="A banana">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
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
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/anona.jpg" class="card-img" alt="A banana">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Custard Apple</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">2.20€/Kg</div>
            </div>
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/green_apple.jpg" class="card-img" alt="A green apple">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Green apples</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">1.00€/Kg</div>
            </div>
        </div>
        <div class="col-8 col-sm-6 col-md-4 col-lg-3">
            <div class="card customcard bg-white text-dark">
                <img src="../images/red_apple.jpg" class="card-img" alt="A red apple">
                <div class="card-img-overlay">

                    <div class="row mb-5 me-1">
                        <div class="col"></div>
                        <div class="col-1"><i class="bi bi-suit-heart"></i></div>
                    </div>
                    <div class="row my-5"></div>
                    <div class="row my-2"></div>
                    <div class="row my-3" ></div>
                    <div class="row mt-5">
                        <div class="col">
                            <p class="card-title">Red apples</p>
                        </div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star-fill" style="color: #d2d820;"></i></div>
                        <div class="col-1"><i class="bi bi-star" style="color: #d2d820;"></i></div>

                    </div>
                </div>
                <div class="card-footer text-muted">1.40€/Kg</div>
            </div>
        </div>
    </div>

    <!-- Hot -->
    <div class="row my-5">
        <div class="col"></div>
        <div class="col-2 text-end">
            <a href="/misc/productList.php" class="link-secondary">See all products<i class="bi bi-arrow-right-short"></i></a>
        </div>
    </div>

</div>


<div class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title"></p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


<?php
    include_once("../common/end.php");
?>
