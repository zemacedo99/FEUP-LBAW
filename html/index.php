<?php
include './common/head.php'
?>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-5">
      <figure class="figure d-flex justify-content-center mt-3 mb-5">
        <img class="figure-img img-fluid rounded" src="https://via.placeholder.com/300x200" alt="">
      </figure>

      <div class="form-floating mb-3">
        <input type="text" class="form-control" id="floatingName" placeholder="John Doe">
        <label for="floatingName">Name</label>
      </div>
      <div class="form-floating mb-3">
        <input type="email" class="form-control" id="floatingEmail" placeholder="name@example.com">
        <label for="floatingEmail">Email address</label>
      </div>
      <div class="form-floating mb-3">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingConfirmPassword" placeholder="Confirm Password">
        <label for="floatingConfirmPassword">Confirm Password</label>
      </div>

      <div class="row mt-3 mb-3">
        <div class="col d-flex justify-content-center">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
            <label class="form-check-label" for="flexRadioDefault1">
              I'm a Customer
            </label>
          </div>
        </div>
        <div class="col d-flex justify-content-center">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
            <label class="form-check-label" for="flexRadioDefault2">
              I'm a Supplier
            </label>
          </div>
        </div>
      </div>


      <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto">
        <button type="submit" class="btn btn-primary">Sign up</button>
        <p class="text-muted mb-0 d-flex justify-content-center"> Already have an account? </p>
        <a href="#" class="link-secondary d-flex justify-content-center">Sign in</a>
      </div>

    </div>
  </div>
</div>

<?php
include './common/end.php'
?>