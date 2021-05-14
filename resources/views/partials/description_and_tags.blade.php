<!-- Description + Tags -->
<div class="row ">
    <label for="Description">Description</label>
</div>

<div class="row  justify-content-center">
    <div class="col-12 col-md-4 col-lg-6">
        {{-- <div class="form">
            <textarea class="form-control" id="Description" rows="5"></textarea>
        </div> --}}


        <div class="form-group mb-1">
            {{-- <label for="description">Description</label> --}}
            <textarea class="form-control" name="description" id="description"
                rows="5">@isset($description) {{ $description }} @endisset</textarea>
        </div>
        <small id="description_alert" class="text-danger"></small>


    </div>




    <div class="col-6 col-lg-6 mt-4 mt-md-0" style="min-height: 100px;">
        <div class="d-grid gap-2 d-lg-block  ">

            {{-- <label for="tags">
                Add tag:
                <input id="tags" name="tags[]" list="tag" multiple>
                <datalist id="tag">
                    @foreach ($tags as $tag)
                        <option value={{ $tag->value }}></option>
                    @endforeach
                </datalist>
            </label> --}}

            
            <div class="container1">
                <button class="add_form_field">Add tag: &nbsp;
                    <span style="font-size:16px;">+ </span>
                </button>
                <div>
                {{-- <input type="text" name="tags[]"> --}}
                <input id="tags" name="tags[]" list="tag" multiple>
                <datalist id="tag">
                    @foreach ($tags as $tag)
                        <option value={{ $tag->value }}></option>
                    @endforeach
                </datalist>
                <a href="#" class="delete">Delete</a>
            </div>
            </div>
            {{-- <button class="btn btn-primary btn-sm">Add+</button>

            <button class="btn btn-secondary btn-sm">Organic X</button>

            <button class="btn btn-secondary btn-sm">Food X</button>

            <button class="btn btn-secondary btn-sm">Fresh X</button>

            <button class="btn btn-secondary btn-sm">Vegetable X</button> --}}
        </div>

    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var max_fields = 5;
        var wrapper = $(".container1");
        var add_button = $(".add_form_field");

        var x = 0;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                // $(wrapper).append(
                //     '<div><input type="text" name="mytext[]"/><a href="#" class="delete">Delete</a></div>'
                // ); //add input box
                $(wrapper).append(
                    '  <div><input id="tags" name="tags[]" list="tag" multiple><datalist id="tag">   @foreach ($tags as $tag)  <option value={{ $tag->value }}></option>@endforeach</datalist><a href="#" class="delete">Delete</a></div>'); //add input box
            } else {
                alert('You Reached the limits')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

</script>
