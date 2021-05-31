@extends('layouts.app')

@section('pagespecificfile')
    <script src="{{ asset('js/register.js') }}" defer></script>
@endsection

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="container">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <figure class="figure d-flex justify-content-center mt-5 mb-5">
                    <img class="figure-img img-fluid rounded" src="{{ asset('images/logo_reset_password.png') }}" alt="">
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
                    <input type="email" name="email" class="form-control" id="floatingEmail" required placeholder="name@example.com" value="{{ old('email') }}">
                    <label class="text-black-50" for="floatingEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" required placeholder="Password">
                    <label class="text-black-50" for="floatingPassword">New Password</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password_confirmation" class="form-control" id="floatingConfirmPassword" required placeholder="Confirm Password">
                    <label class="text-black-50" for="floatingConfirmPassword">Confirm New Password</label>
                </div>

                <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto mb-5">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <p class="text-muted mb-0 d-flex justify-content-center"> Already have an account? </p>
                    <a href="" data-bs-toggle="modal"
                       data-bs-target="#loginModal" class="link-secondary d-flex justify-content-center">Sign in</a>
                </div>
            </div>
        </div>
    </form>
@endsection
