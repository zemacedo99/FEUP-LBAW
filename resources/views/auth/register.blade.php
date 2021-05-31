@extends('layouts.app')

@section('pagespecificfile')
    <script src="{{ asset('js/register.js') }}" defer></script>
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}" class="container">
        @csrf
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <figure class="figure d-flex justify-content-center mt-5 mb-5">
                    <img class="figure-img img-fluid rounded" src="{{asset('images/logo_register.png')}}" alt="">
                </figure>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-floating mb-3">
                    <input type="text" name="name" class="form-control" id="floatingName" required placeholder="John Doe" value="{{ old('name') }}">
                    <label class="text-black-50" for="floatingName">Name</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" required placeholder="name@example.com" value="{{ old('email') }}">
                    <label class="text-black-50" for="floatingEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" required placeholder="Password">
                    <label class="text-black-50" for="floatingPassword">Password</label>
                </div>
                <div class="form-floating">
                    <input type="password" name="password_confirmation" class="form-control" id="floatingConfirmPassword" required placeholder="Confirm Password">
                    <label class="text-black-50" for="floatingConfirmPassword">Confirm Password</label>
                </div>

                <div class="row mt-3 mb-3">
                    <div class="col d-flex justify-content-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="client"
                                   id="flexRadioDefault1"
                                   checked
                                   data-bs-toggle="collapse" data-bs-target=".collapseOne.show">
                            <label class="form-check-label" for="flexRadioDefault1">
                                I'm a Customer
                            </label>
                        </div>
                    </div>
                    <div class="col d-flex justify-content-center">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type" value="supplier"
                                   id="flexRadioDefault2" data-bs-toggle="collapse" data-bs-target=".collapseOne:not(.show)">
                            <label class="form-check-label" for="flexRadioDefault2">
                                I'm a Supplier
                            </label>
                        </div>
                    </div>
                </div>

                <div class="collapseOne panel-collapse collapse">
                    <div class="panel-body">
                        <div class="alert alert-success text-center" role="alert">
                            <i class="bi bi-exclamation-triangle"></i>
                            Supplier registrations are subject to confirmation
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" name="address" class="form-control" id="floatingAddress" placeholder="Address" value="{{ old('address') }}">
                            <label class="text-black-50" for="floatingAddress">Address</label>
                        </div>

                        <div class="row g-0 mb-3">
                            <div class="col form-floating me-3">
                                <input type="text" name="post-code" class="form-control" id="floatingPostCode" placeholder="PostCode" value="{{ old('post-code') }}">
                                <label class="text-black-50" for="floatingPostCode">Post Code</label>
                            </div>
                            <div class="col form-floating">
                                <input type="text" name="city" class="form-control" id="floatingCity" placeholder="City" value="{{ old('city') }}">
                                <label class="text-black-50" for="floatingCity">City</label>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" placeholder="Leave your description here"
                                      id="floatingDescription" style="height: 100px">{{ old('description') }}</textarea>
                            <label class="text-black-50" for="floatingDescription">Description</label>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto mb-5">
                    <button type="submit" class="btn btn-primary">Sign up</button>
                    <p class="text-muted mb-0 d-flex justify-content-center"> Already have an account? </p>
                    <a href="" data-bs-toggle="modal"
                       data-bs-target="#loginModal" class="link-secondary d-flex justify-content-center">Sign in</a>
                </div>

            </div>
        </div>
    </form>
@endsection
