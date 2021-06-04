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
                    <h2 class="text-center">Users</h2>
                </div>
                <div class="row">
                    <form action="">
                        <div class="col-8 col-md-4">
                            <form class="d-flex" method="GET" action="dashboard_users/search">
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
                                $users->setPath("dashboard_clients");
                            @endphp

                        @foreach ($users->items() as $user)

                            <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>
                                <div class="row">
                                        <div class="col-7">{{$user->name}}</div>
                                        <div class="col-5">
                                            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#deleteUserModal" data-bs-whatever={{$user->id}} user-name={{$user->name}}><i class="bi bi-trash"></i></button>
                                            <a href="/users/{{$user->id}}" class="btn btn-primary btn-sm d-none d-md-inline"><i
                                                class="bi bi-info-circle" ></i></a>
                                        </div>
                                    </div>
                                </td>

                            </tr>

                        @endforeach

                        </tbody>
                    </table>
                </div>

                @include('partials.pages', ['link'=>"dashboard_clients",'paginator'=>$users])

                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-primary" href="{{ route('dashboard') }}"><i class="bi bi-arrow-left"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Deleting user</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure that you want to delete this user?</p>
                    <p id="user_id" class="fw-bold text-center"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary">Yes</button>
                </div>
            </div>
        </div>
    </div>

@endsection
