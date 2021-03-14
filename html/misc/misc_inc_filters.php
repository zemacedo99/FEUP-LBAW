<!-- <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapsefilters" aria-expanded="false" aria-controls="collapseExample">
    Button with data-bs-target
  </button> -->

<!-- <nav id="filters" class="col-md-3 col-lg-2 d-md-block bg-light sidebar" style="overflow-y: scroll;overflow-x: hidden;"> -->

<link rel="stylesheet" href="./sidebar.css">

<aside>
    <nav id="sidebar" class="collapse order-0" style="background-color: #F3F2F4; width: max-content;">
        <div class="row justify-content-end">
            <button id="sidebar-toggler" class="btn bd-sidebar-toggle col-2 " type="button" data-bs-toggle="collapse"
                data-bs-target="#sidebar" aria-controls="filters" aria-expanded="false" aria-label="toggle-filters">
                <i class="bi bi-x-circle"></i>
            </button>
        </div>
        <ul class="mt-5">
            

                <div class="row ">
                    <div class="col">

                        <input type="radio" class="btn-check " name="options" id="storesOption"
                            autocomplete="off" checked>
                        <label class="btn btn-secondary mb-5" for="storesOption">Stores</label>
                    </div>

                    <div class="col ">
                        <input type="radio" class="btn-check " name="options" id="productsOption"
                            autocomplete="off">
                        <label class="btn btn-secondary mb-5" for="productsOption">Products</label>
                    </div>
                </div>

                <!-- <div class="row align-content-center">
                    <div class="col align-content-center">

                        <input type="radio" class="btn-check align-content-center" name="options" id="storesOption"
                            autocomplete="off" checked>
                        <label class="btn btn-secondary mb-5" for="storesOption">Stores</label>
                    </div>

                    <div class="col align-content-center">
                        <input type="radio" class="btn-check align-content-center" name="options" id="productsOption"
                            autocomplete="off">
                        <label class="btn btn-secondary mb-5" for="productsOption">Products</label>
                    </div>
                </div> -->


                <hr class="dropdown-divider">

                <ul class="list-unstyled mb-0 pt-md-1">
                    <button class="btn d-inline-flex align-items-center rounded" data-bs-toggle="collapse"
                        data-bs-target="#category" aria-expanded="false">
                        <h4>Categories</h4>
                    </button>
                    <div class="collapse.show" id="category">
                        <ul class="list-unstyled fw-normal pb-1 small">
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="food">
                                <label class="form-check-label" for="food">
                                    food
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="fertilizer">
                                <label class="form-check-label" for="fertilizer">
                                    fertilizer
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="pesticides">
                                <label class="form-check-label" for="pesticides">
                                    pesticides
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="biologic">
                                <label class="form-check-label" for="biologic">
                                    biologic
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="gardening">
                                <label class="form-check-label" for="gardening">
                                    gardening
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="tools">
                                <label class="form-check-label" for="tools">
                                    tools
                                </label>
                            </li>
                        </ul>
                    </div>
                </ul>
                <hr class="dropdown-divider">

                <ul class="list-unstyled mb-0  pt-md-1">
                    <h4>Price Range</h4>

                    <div class="row">
                        <div class="col-5">
                            <input type="number" class="form-control" placeholder="Min" min=0>
                        </div>
                        <div class="col-1"></div>
                        <div class="col-5 ">
                            <input type="number" class="form-control" placeholder="Max" min=0>
                        </div>
                    </div>

                </ul>

                <hr class="dropdown-divider">

                <ul class="list-unstyled mb-0 py-3 pt-md-1">
                    <h4>Rating</h4>
                    <div class="row">
                        <div class="col-5">
                            <div class="rating"> <input type="radio" name="ratingmin" value="5" id="5min"><label
                                    for="5min">☆</label> <input type="radio" name="ratingmin" value="4" id="4min"><label
                                    for="4min">☆</label> <input type="radio" name="ratingmin" value="3" id="3min"><label
                                    for="3min">☆</label> <input type="radio" name="ratingmin" value="2" id="2min"><label
                                    for="2min">☆</label> <input type="radio" name="ratingmin" value="1" id="1min"><label
                                    for="1min">☆</label>
                            </div>
                        </div>
                        <div class="col-1">
                            <h4> - </h4>
                        </div>
                        <div class="col-5">
                            <div class="rating"> <input type="radio" name="ratingmax" value="5" id="5max"><label
                                    for="5max">☆</label> <input type="radio" name="ratingmax" value="4" id="4max"><label
                                    for="4max">☆</label> <input type="radio" name="ratingmax" value="3" id="3max"><label
                                    for="3max">☆</label> <input type="radio" name="ratingmax" value="2" id="2max"><label
                                    for="2max">☆</label> <input type="radio" name="ratingmax" value="1" id="1max"><label
                                    for="1max">☆</label>
                            </div>
                        </div>
                    </div>
                </ul>

                <ul class="list-unstyled mb-0 py-3 pt-md-1">

                    <h4>Countries</h4>

                    <li class="collapse.show" id="country">
                        <ul class="list-unstyled fw-normal pb-1 small">
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Poland
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Jamaica
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Portugal
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Canada
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Congo
                                </label>
                            </li>
                            <li class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    China
                                </label>
                            </li>

                        </ul>

                </ul>


        </ul>
    </nav>

</aside>

<button id="sidebar-toggler" class="btn bd-sidebar-toggle bg-secondary" style="width: max-content;" type="button"
    data-bs-toggle="collapse" data-bs-target="#sidebar" aria-controls="filters" aria-expanded="false"
    aria-label="toggle-filters">
    Filters
</button>
</div>

<!--
    <div id="MaxDistance" class="container border-bottom mt-5">
        <b>Max Distance</b>
        <!--https://seiyria.com/bootstrap-slider/-->
<!--<input id="distance" type="range" class="span2" value="0" data-slider-min="0" data-slider-max="1000"
            data-slider-step="5">
        <input name="MaxDistanceRepresentation" type="number" class="form-control disable" placeholder="0">

    </div>-->