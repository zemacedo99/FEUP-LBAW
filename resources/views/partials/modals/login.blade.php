<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Welcome Back</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="row  d-flex justify-content-center">
                        <div class="col-9">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="name@example.com" required>
                                <label class="text-black-50" for="floatingEmail">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label class="text-black-50" for="floatingPassword">Password</label>
                            </div>
                        </div>
                    </div>


                    <div class="d-grid gap-2 col-6 col-sm-5 col-md-7 mx-auto mb-3">
                        <button type="submit" class="btn btn-primary">Sign in</button>
                        <p class="text-muted mb-0 d-flex justify-content-center"> Don't have an account? </p>
                        <a href="{{ route('register') }}" class="link-secondary d-flex justify-content-center">Sign up</a>
                        <a href="{{ route('password.request') }}" class="link-secondary d-flex justify-content-center">Forgot my password</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
