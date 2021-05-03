@extends('layouts.app')

@section('content')

<div class="container">

    <div class="row">
        <div id="mainContainer" class="col-sm-8">

            @include('partials.bundle')


        </div>
        <div id="DataContainer" class="col-md-4">
            <h2>test</h2>
            <h6 class="text-muted">Only 2 left!</h6>
            <br>
            <p>
            <h4><b>4,50€/kg</b></h4>
            </p>
            <br>
            <p>Quantity</p>
            <input type="number" class="col-auto" id="quantity" placeholder="2"> <b>KG</b>
            <div class="text-muted">Total: 9,00€</div>
            <br>
            <br>
            <div id="confirmContainer" class="text-center">
                <button type="button" class="btn btn-light"><i>Buy </i><i class="bi bi-basket"></i></button>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div id="DescriptionContainer" class="container-fluid">
            <div class="form-group">
                <label for="Description">Description</label>
                <textarea class="form-control" id="Description" rows="5" readonly>Fresh and green letuce from the renowned fields of Póvoa do Varzim in Portugal. This lettuce is freshly picked every morning to preserve the essence of its flavour until it reaches your table. Biological food means sustainable food! Eat healthier.
          </textarea>
            </div>
        </div>
        <div id="TagsContainer" class="container-fluid mt-5">
            <div class="form-group">
                <label for="tags">Tags</label>
                <div class="container" id="tags" style="border: 1px solid">
                    <span class="badge bg-secondary">Organic</span>
                    <span class="badge bg-secondary">Food</span>
                    <span class="badge bg-secondary">Fresh</span>
                    <span class="badge bg-secondary">Vegetable</span>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div id="Reviews" class="row mt-5">
            <h2>What other costumers say:</h2>
            <br>
            <div class="container mt-3" style="border:solid">
                <div class="row">
                    <h3>Alice </h3>
                </div>
                <div class="row text-end justify-content-right justify-content-end">
                    <div class="rating text-end"> <input type="radio" name="ratingalice" value="5" id="5alice"><label for="5alice">☆</label> <input type="radio" name="ratingalice" value="4" id="4alice"><label for="4alice">☆</label> <input type="radio" name="ratingalice" value="3" id="3alice"><label for="3alice">☆</label> <input type="radio" name="ratingalice" value="2" id="2alice"><label for="2alice">☆</label> <input type="radio" name="ratingalice" value="1" id="1alice"><label for="1alice">☆</label>
                    </div>
                </div>
                <div class="row">
                    <div class="text-muted">The lettuce was flavourful, supermarket's lettuce isn't nearly as tasteful</div>
                </div>
            </div>


            <div class="container mt-2" style="border:solid">
                <h3>João </h3>
                <div class="rating text-end"> <input type="radio" name="ratingalice" value="5" id="5alice"><label for="5alice">☆</label> <input type="radio" name="ratingalice" value="4" id="4alice"><label for="4alice">☆</label> <input type="radio" name="ratingalice" value="3" id="3alice"><label for="3alice">☆</label> <input type="radio" name="ratingalice" value="2" id="2alice"><label for="2alice">☆</label> <input type="radio" name="ratingalice" value="1" id="1alice"><label for="1alice">☆</label>
                </div>
                <div class="text-muted">They call it biological but seeing snails in the lettuce makes me think only in lack
                    of hygiene.</div>
            </div>
        </div>
    </div>

</div>

@endsection