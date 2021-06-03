<!-- Description + Tags -->
<script type="text/javascript" src={{ asset('js/tags.js') }} > </script>

<div class="row ">
    <label for="Description">Description</label>
</div>

<div class="row  justify-content-center">
    <div class="col-12 col-lg-6">
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
                
                <button type="button" onclick="addItem()" class="btn btn-primary btn-sm">Add tag + </button>
                
                <input id="tags" name="tags[]" list="tag" size="13" maxlength="13" multiple>
                <datalist id="tag">
                    @foreach ($alltags as $tag)
                    <option value={{ $tag->value }}></option>
                    @endforeach
                </datalist>
                {{-- <a href="#" class="delete" onclick="removeItem()"><i class="bi bi-trash"></i></a> --}}
                
                
                <div class="row mb-3"></div>
                <div id="dynamic_tags"></div>
            </div>

            <input type="hidden" name="t" id="t">
            
            @isset($itemtags)
            
                @foreach ($itemtags as $tag)
                    {{-- <button class="btn btn-secondary btn-sm me-2 mb-1" id="{{$tag->value}}" onclick="removeOnBtn({{$tag->value}})">{{$tag->value}}</button> --}}
                    <script>
                        addTag('{{$tag->value}}');
                    </script>
                @endforeach
            @endisset

            <div id="alltags"> </div>

            <div class="row mb-1"></div>

            <div id="dynamic_tags"></div>
            


            {{-- <button class="btn btn-primary btn-sm">Add+</button>

            <button class="btn btn-secondary btn-sm">Organic X</button>

            <button class="btn btn-secondary btn-sm">Food X</button>

            <button class="btn btn-secondary btn-sm">Fresh X</button>

            <button class="btn btn-secondary btn-sm">Vegetable X</button> --}}
        </div>

    </div>
</div>

{{-- credits to : https://stackoverflow.com/questions/14853779/adding-input-elements-dynamically-to-form --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var max_fields = 3;
        var wrapper = $(".container1");
        var add_button = $(".add_form_field");

        var x = 1;
        $(add_button).click(function(e) {
            e.preventDefault();
            if (x < max_fields) {
                x++;
                // $(wrapper).append(
                //     '<div><input type="text" name="mytext[]"/><a href="#" class="delete">Delete</a></div>'
                // ); //add input box
                $(wrapper).append(
                                    '<div><input id="tags" name="tags[]" list="tag" size="13" maxlength="13" multiple><datalist id="tag">@foreach ($alltags as $tag)<option value={{ $tag->value }}></option>@endforeach</datalist><a href="#" class="delete"><i class="bi bi-trash"></i></a></div>'
                                ); //add input box
            } else {
                alert('You reached the max tags (3)')
            }
        });

        $(wrapper).on("click", ".delete", function(e) {
            e.preventDefault();
            $(this).parent('div').remove();
            x--;
        })
    });

</script> --}}
