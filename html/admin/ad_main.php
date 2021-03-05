<?php
include '../common/head.php';

?>
<div class="container-fluid mt-5">
    <div class="row ">
        <div class="col-3 mx-3 py-5 align-self-center" style="border-right: 1px solid gray; height: 700px;">

            <div class="row my-5">View suppliers request</div>
            <div class="row my-5">View products</div>
            <div class="row my-5">View users </div>
        </div>
        <div class="col-7 ">
            <h2 class="my-5 text-center">Welcome, admin!</h2>

            <form action="">
                <div class="col-4">
                    <input class="form-control" placeholder="Search">
                </div>
            </form>

            <table class="table mt-3">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">#1</th>
                        <td>
                            <div class="row">
                                <div class="col-7">Zé das bananas</div>
                                <div class="col-5">
                                    <button><i class="bi bi-check"></i></button>
                                    <button><i class="bi bi-x"></i></button>
                                    <button><i class="bi bi-info-circle"></i></button>
                                </div>
                            </div>
                        </td>

                    </tr>

                    <tr>
                        <th scope="row">#2</th>
                        <td>
                            <div class="row">
                                <div class="col-7">Luís das beterrabas</div>
                                <div class="col-5">
                                    <button><i class="bi bi-check"></i></button>
                                    <button><i class="bi bi-x"></i></button>
                                    <button><i class="bi bi-info-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">#3</th>
                        <td>
                            <div class="row">
                                <div class="col-7">André dos pêssegos</div>
                                <div class="col-5">
                                    <button><i class="bi bi-check"></i></button>
                                    <button><i class="bi bi-x"></i></button>
                                    <button><i class="bi bi-info-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row">#4</th>
                        <td>
                            <div class="row">
                                <div class="col-7">Ricardo das ananonas</div>
                                <div class="col-5">
                                    <button><i class="bi bi-check"></i></button>
                                    <button><i class="bi bi-x"></i></button>
                                    <button><i class="bi bi-info-circle"></i></button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


<?php include '../common/end.php' ?>