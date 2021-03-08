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


<div class="container-fluid" >
    <div class="row" style="align-items: center;" >
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
        <div class="col-md-10">
            <div class="row mx-auto">
                <h1 class="my-5 text-center">Welcome, admin!</h1>
            </div>


            <div class="row my-5 mx-auto d-block d-md-none">
                <div class="col-12 text-center">
                    <a class="btn btn-outline-primary" href="view_req.php" >View suppliers request</a>
                </div>
            </div>
            
            <div class="row my-5 mx-auto d-block d-md-none">
                <div class="col-12 text-center">
                    <a class="btn btn-outline-primary" href="view_prods.php">View products</a>
                </div>            
            </div>

            <div class="row my-5 mx-auto d-block d-md-none">
                <div class="col-12 text-center">
                    <a class="btn btn-outline-primary" href="view_users.php">View users</a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../common/end.php' ?>