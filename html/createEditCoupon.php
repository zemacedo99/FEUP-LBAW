<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">


  <title>Title of the document</title>
</head>

<body>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0"
    crossorigin="anonymous"></script>

  <div class="container">

    <div class="pt-4 my-md-5 pt-md-5 border-bottom">
      <P> Create Product</P>
    </div>

    <div class="row">
      <div id="imagesContainer" class="col-sm-8">
        <div class="image-upload">
          <label for="file-input">
            <img src="genericAddImage"/>
          </label>
          <input id="file-input" type="file" class="invisible"/>
        </div>
        
      </div>
      <div id="DataContainer" class="col-md-4">
        <P>Coupon Name</P>
        <p>Unit</p>
        <p>€</p>
        <p>KG</p>
        <div class="col-auto my-1">
          <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
          <select class="custom-select mr-sm-2" id="inlineFormCustomSelect">
            <option selected>Choose...</option>
            <option value="1">One</option>
            <option value="2">Two</option>
            <option value="3">Three</option>
          </select>
      </div>
    </div>
  
  <div class="row">
    <div id="DescriptionContainer" class="col-sm-6">
      <div class="form-group">
        <label for="Description">Description</label>
        <textarea class="form-control" id="Description" rows="5"></textarea>
      </div>
    </div>
    <div id="OtherInformationContainer" class="col-sm-6">
      <div class="form-group row">
        <b>
        <label for="Coupon expire date" class="col-2 col-form-label">Date</label>
        </b>
        <div class="col-10">
          <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
        </div>
      </div>
      <div class="form-group row">
        <b>
        <label for="Coupon Code" class="col-2 col-form-label">Code</label>
        </b>
        <div class="col-10">
          <input class="form-control" type="text" value="Code" id="example-search-input">
        </div>
      </div>
    </div>
  </div>
  


  <div class="row">
    <div id="deleteProductContainer" class="float-end">
      <p>Delete Product <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
          class="bi bi-trash" viewBox="0 0 16 16">
          <path
            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
          <path fill-rule="evenodd"
            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
        </svg></p>
    </div>

    <div id="confirmContainer" class="text-center">
      <button type="button" class="btn btn-light">Confirmar</button>
    </div>
  </div>
  </div>
  </div>
</body>

</html>