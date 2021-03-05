<?php
include '../common/head.php';
include '../common/navbar.php';
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Modal de Login
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Welcome Back</h5>
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
          <a href="../credentials/register.php" class="link-secondary d-flex justify-content-center">Sign up</a>
        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

<?php include '../common/end.php' ?>