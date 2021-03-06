<?php
include '../common/head.php';
?>

<div class="container-fluid" >
    <div class="row" style="align-items: center;" >
        <div class="col-2 d-none d-md-block" style="border-right: 1px solid gray; height: 750px">

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
                    <a class="btn btn-outline-primary" href="view_req.php">View suppliers request</a>
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