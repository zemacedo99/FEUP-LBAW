<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Welcome Back</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row  d-flex justify-content-center">
                    <div class="col-9">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com">
                            <label class="text-black-50" for="floatingEmail">Email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
                            <label class="text-black-50" for="floatingPassword">Password</label>
                        </div>
                    </div>
                </div>


                <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto mb-3">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Sign in</button>
                    <p class="text-muted mb-0 d-flex justify-content-center"> Don't have an account? </p>
                    <a href="../credentials/register.php" class="link-secondary d-flex justify-content-center">Sign
                        up</a>
                </div>
            </div>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-md navbar-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('homepage') }}"> <img alt="Logo" src="../images/logo.png" width="100" height="25">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="../misc/products_list.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="../misc/products_list.php">Stores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('about_us') }}">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="navLinks" href="{{ route('map') }}">SiteMap</a>
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
                <button type="button" id="headericon" data-bs-toggle="modal"
                        data-bs-target="#loginModal">account_circle
                </button>
                <a href="../checkout/cart_info.php">
                    <button type="button" id="headericon">shopping_cart</button>
                </a>
            </div>
        </div>
    </div>
</nav>
