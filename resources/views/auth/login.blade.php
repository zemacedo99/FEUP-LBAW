@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}" class="container">
        @csrf
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5 col-xxl-4">
                <figure class="figure d-flex justify-content-center mt-5 mb-5">
                    <img class="figure-img img-fluid rounded" src="{{asset('images/logo_login.png')}}" alt="">
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

                @isset($status)
                    <div class="alert alert-success">
                        <ul>
                            <li>{{ $status }}</li>
                        </ul>
                    </div>
                @endisset

                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" required placeholder="name@example.com" value="{{ old('email') }}">
                    <label class="text-black-50" for="floatingEmail">Email address</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword" required placeholder="Password">
                    <label class="text-black-50" for="floatingPassword">Password</label>
                </div>

                <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto mb-3">
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Sign in</button>
                    <p class="text-muted mb-0 d-flex justify-content-center"> Don't have an account? </p>
                    <a href="{{ route('register') }}" class="link-secondary d-flex justify-content-center">Sign up</a>
                    <a href="{{ route('password.request') }}" class="link-secondary d-flex justify-content-center">Forgot my password</a>
                </div>

            </div>
        </div>
    </form>
@endsection
