<?php
include_once '../credentials/login.php';

/**
 * Adds the header part of the webpage with a customizable title
 * 
 * @param String $title The title to be displayed in the browser tab
 */
function pageHeader($title)
{ ?>
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

        <!-- Material icons-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

        <!-- FavIcon -->
        <link rel="shortcut icon" href="../images/favicon.ico" type="image/png">
        <link rel="icon" href="../images/favicon.ico" type="image/png">

        <!-- Self included style and scripts -->
        <link rel="stylesheet" type="text/css" href="../style.css">

        <title><?= $title ?></title>
    </head>

    <body class="h-100 d-flex flex-column">
        <!-- Optional JavaScript; choose one of the two! -->
        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

    <?php
}
/**
 *  Adds a navbar to the webpage
 * 
 *  @see 'addLogin'
 */
function navbar()
{
    addLogin();
    ?>
        <nav class="navbar navbar-expand-md navbar-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="../index.php"> <img alt="Logo" src="../images/logo.png" width="100" height="25"> </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="../misc/productList.php">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="../misc/productList.php">Stores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="../misc/about_us.php">About Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="navLinks" href="../misc/site_map.php">SiteMap</a>
                        </li>
                    </ul>

                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button type="button" id="headericon">search</button>
                    </form>
                </div>

                <!-- navbar profile and cart buttons -->
                <div class="navbar-nav ms-auto">
                    <div class="col align-items-end">
                        <button type="button" id="headericon" data-bs-toggle="modal" data-bs-target="#loginModal">account_circle</button>
                        <a href="../checkout/cart_info.php"><button type="button" id="headericon">shopping_cart</button></a>
                    </div>
                </div>
        </nav>

        <!-- <nav class="navbar navbar-expand-md navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="/misc/home_page.php">
                    <img src="../images/favicon.ico" alt="" width="30" height="24" class="d-inline-block align-top">
                    MyGarden
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link" href="#">Products</a>
                        <a class="nav-link" href="#">Stores</a>
                        <a class="nav-link" href="/misc/about_us.php">About Us</a>
                        <a class="nav-link d-block d-md-none" href="#">Client</a>
                        <a class="nav-link d-block d-md-none" href="#">Cart</a>
                    </div>
                </div>
                <a href="../client/client_profile.php" class="d-none d-md-inline-block"><i class="bi bi-person fs-2"></i></a>
                <a href="#" class="d-none d-md-inline-block"><i class="bi bi-cart3 fs-2"></i></a>
            </div>
        </nav> -->
    <?php
}

/**
 * Adds a footer to the webpage, and closes the body and html tags
 */
function footer()
{
    ?>
        <footer class="footer mt-auto py-3 bg-light">
            <div class="container">
                <span class="text-muted">MyGarden tm.</span>
            </div>
        </footer>

    </body>

    </html>
<?php
}
/**
 * Add ` data-bs-toggle="modal" data-bs-target="#modalDeleteAccount" ` to the corresponding trigger
 * 
 * @param String $modalName Identificador do Modal
 * @param String $title Title for the modal window
 * @param String $bodyText Text in the body of the modal
 * @param String $buttonPrimary Text in the primary button
 * @param String $buttonSecondary Text in the secondary button
 * 
 * @return null
 */
function addModal($modalName, $title, $bodyText, $buttonPrimary, $buttonSecondary)
{ ?>
    <div class="modal fade" id="modal<?= $modalName; ?>" tabindex="-1" aria-labelledby="modal<?= $modalName; ?>Label" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal<?= $modalName ?>Label"><?= $title ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?= $bodyText ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= $buttonSecondary ?></button>
                    <button type="button" class="btn btn-primary"><?= $buttonPrimary ?></button>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>


<?php
function perfilSupplier($image, $name)
{
?>
    <div class="row mt-3"></div>
    <div class="row mt-3"></div>

    <div class="row ">
        <div class="col-12 col-lg-5">

            <div class="row d-flex justify-content-center mb-3">
                <div class="col-12 col-lg-6" style="width: 15rem;">
                    <img src="../images/<?= $image ?>" class="rounded-circle img-fluid">
                </div>
                <div class="col-12 col-lg-6 d-flex align-items-center justify-content-center justify-content-lg-start">
                    <p class="col-md-auto text-decoration-underline text-center">
                    <h3><?= $name ?></h3>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <div class="row mt-3"></div>
    <div class="row mt-3"></div>
<?php
}
?>