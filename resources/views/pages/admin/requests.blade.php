@extends('layouts.admin')

@section('pagespecificfile')
    <script src="{{ asset('js/admin_modal.js') }}" defer></script>
@endsection

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-2 d-none d-md-block" style="border-right: 1px solid #53ca61; height: 750px">

                <div class="row py-5"></div>
                <div class="row pb-5"></div>
                <div class="row pb-5"></div>


                <div class="row my-5 mx-auto">
                    <div class="col-12 ">
                        <a class="btn btn-outline-primary" href="{{ route('admin_requests') }}">View suppliers request</a>
                    </div>
                </div>

                <div class="row my-5 mx-auto">
                    <div class="col-12">
                        <a class="btn btn-outline-primary" href="{{ route('admin_products') }}">View products</a>
                    </div>
                </div>

                <div class="row my-5 mx-auto">
                    <div class="col-12">
                        <a class="btn btn-outline-primary" href="{{ route('admin_users') }}">View users</a>
                    </div>
                </div>
            </div>
            <div class="col-9 ms-5 my-5">
                <div class="row my-5"></div>
                <div class="row mb-5">
                    <h2 class="text-center">Suppliers Requests</h2>
                </div>
                <div class="row">
                    <form action="">
                        <div class="col-8 col-md-4">
                            <form class="d-flex" method="GET" action="dashboard_requests/search">
                                @csrf
                                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="search" name="search">
                                
                            </form>
                        </div>
                    </form>
                </div>

                <div class="row">
                    <table class="table mt-3">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>

                        </tr>
                        </thead>
                        <tbody>

                            @php
                                $i = $suppliers->perPage()*($suppliers->currentPage()-1);
                            @endphp

                        @foreach ($suppliers as $supplier)
                            @php
                             $i+=1;
                            @endphp
                            <tr>
                            <th scope="row">#{{$i}}</th>
                            <td>
                                <div class="row">
                                        <div class="col-7">{{$supplier->name}}</div>
                                        <div class="col-5">
                                            <button class="btn btn-primary btn-sm d-inline d-md-none"><i class="bi bi-gear"></i></button>
                                            <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#acceptSupModal" request-id={{$i}} data-bs-whatever={{$supplier->id}}><i class="bi bi-check"></i></button>
                                            <button class="btn btn-primary btn-sm d-none d-md-inline" data-bs-toggle="modal" data-bs-target="#declineSupModal" request-id={{$i}} data-bs-whatever={{$supplier->id}}><i class="bi bi-x"></i></button>
                                            <a href="/supplier/{{$supplier->id}}" class="btn btn-primary btn-sm d-none d-md-inline"><i
                                                class="bi bi-info-circle" ></i></a>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                        @endforeach


                        </tbody>
                    </table>
                </div>

                @include('partials.pages',['link'=>"dashboard_products",'paginator'=>$suppliers])

                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-primary" href="{{ route('dashboard') }}"><i class="bi bi-arrow-left"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="acceptSupModal" tabindex="-1" aria-labelledby="acceptSupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="acceptSupModalLabel">Confirming supplier request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to confirm this supplier?</p>
                    <p id="req_id" class="fw-bold text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="declineSupModal" tabindex="-1" aria-labelledby="declineSupModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="declineSupModalLabel">Confirming supplier request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to reject this supplier?</p>
                    <p id="req_id" class="fw-bold text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
