<div class=" col-xl-3 col-lg-4 col-md-6 col-sm-10 col-10 mx-auto">
    <div class="p-3">
        <div class="card">

            <div class="col">
                <img src={{ asset('storage/products/bundle.jpg') }} class="img-fluid" alt="bundle" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
            </div>

            <div class="card-img-overlay">
                <div class="text-center">
                    <br><br>
                    <h5 class="card-title " style="  font-weight: bold;">{{$name}}</h5>
                    <p class="card-text">{{$price}}€</p>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">

                    <div class="col-6 ">
                        <small class="text-muted"> Stock left: {{$stock}}<br></small>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="{{ route('edit_bundle', ['id' => $id]) }}" class="stretched-link"  > <button type="button" class="simpleicon" >edit</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
