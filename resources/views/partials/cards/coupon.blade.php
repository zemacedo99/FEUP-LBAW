<!-- <div class="col-lg-12 col-10 mx-auto"> -->
<div class="col-lg-4 col-10 mx-auto">
    <div class="p-3">
        <div class="card">

            <div class="col">
                <img src="{{asset('storage/images/otap071yo9zJOzlhOLXJsgtvxAmlG0D5SkwfJzOJ.jpg')}}" class="img-fluid" alt="cupon" style="margin-left:auto; margin-right:auto;width:40em;height:10em;">
            </div>


            <div class="card-img-overlay">
                <div class="text-center">
                    <br><br>
                    <h5 class="card-title">{{$name}}</h5>
                    <p class="card-text">{{$amount}}{{$type}}</p>
                </div>
            </div>

            <div class="card-footer">
                <small class="text-muted">Valid until {{$expirationDate}}</small>
            </div>


        </div>
    </div>
</div>
