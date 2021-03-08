<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../style.css">
  <!-- FavIcon -->
  <link rel="shortcut icon" href="./images/favicon.ico" type="image/png">
  <link rel="icon" href="./images/favicon.ico" type="image/png">
  <title>MyGarden</title>
</head>

<body>
  <!-- Optional JavaScript; choose one of the two! -->
  <!-- Option 1: Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

<script src="admin_modal.js" defer></script>

<div class="container-fluid">
    <div class="row">
        <div class="col-2 d-none d-md-block" style="border-right: 1px solid #53ca61; height: 750px">

            <div class="row py-5"></div>
            <div class="row pb-5"></div>
            <div class="row pb-5"></div>


            <div class="row my-5 mx-auto">
                <div class="col-12 ">
                    <a class="btn btn-outline-primary" href="view_req.php">View suppliers request</a>
                </div>
            </div>

            <div class="row my-5 mx-auto">
                <div class="col-12">
                    <a class="btn btn-outline-primary" href="view_prods.php">View products</a>
                </div>
            </div>

            <div class="row my-5 mx-auto">
                <div class="col-12">
                    <a class="btn btn-outline-primary" href="view_users.php">View users</a>
                </div>
            </div>
        </div>
        <div class="col-9 ms-5 mt-5">
            <div class="row my-5"></div>
            <div class="row mb-5">
                <h2 class="text-center">Products</h2>
            </div>
            <div class="row ">
                <form action="">
                    <div class="col-8 col-md-4">
                        <input class="form-control" placeholder="Search">
                    </div>
                </form>
            </div>

            <div class="row">
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Supplier</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">#1</th>
                            <td>Bananas amarelinhas</td>
                            <td>
                                <div class="row">
                                    <div class="col-7">Zé das bananas</div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm d-inline d-md-none"><i class="bi bi-gear"></i></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#deleteProdModal" data-bs-whatever="1"><i class="bi bi-trash"></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline"><i class="bi bi-info-circle"></i></button>
                                    </div>
                                </div>
                            </td>

                        </tr>

                        <tr>
                            <th scope="row">#2</th>
                            <td>Beterrabas bem boas</td>
                            <td>
                                <div class="row">
                                    <div class="col-7">Luís das beterrabas</div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm d-inline d-md-none"><i class="bi bi-gear"></i></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#deleteProdModal" data-bs-whatever="2"><i class="bi bi-trash"></i></button>

                                        <button class="btn btn-primary btn-sm d-none d-md-inline"><i class="bi bi-info-circle"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">#3</th>
                            <td>Pessêgos redondos</td>
                            <td>
                                <div class="row">
                                    <div class="col-7">André dos pêssegos</div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm d-inline d-md-none"><i class="bi bi-gear"></i></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#deleteProdModal" data-bs-whatever="3"><i class="bi bi-trash"></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline"><i class="bi bi-info-circle"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <th scope="row">#4</th>
                            <td>Anonas bueda doces</td>
                            <td>
                                <div class="row">
                                    <div class="col-7">Ricardo das ananonas</div>
                                    <div class="col-5">
                                        <button class="btn btn-primary btn-sm d-inline d-md-none"><i class="bi bi-gear"></i></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#deleteProdModal" data-bs-whatever="4"><i class="bi bi-trash"></i></button>
                                        <button class="btn btn-primary btn-sm d-none d-md-inline" ><i class="bi bi-info-circle"></i></button>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row mt-4">
                <div class="col-2">
                    <a class="btn btn-primary" href="dashboard.php"><i class="bi bi-arrow-left"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteProdModal" tabindex="-1" aria-labelledby="deleteProdModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteProdModalLabel">Confirming supplier request</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Are you sure that you want to delete this product?</p>
        <p id="prod_id" class="fw-bold text-center"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
        <button type="button" class="btn btn-primary">Yes</button>
      </div>
    </div>
  </div>
</div>


<?php include '../common/end.php' ?>