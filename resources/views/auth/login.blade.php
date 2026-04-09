@include('components.header')

@if (session()->has('success'))
    <div class="container container--narrow">
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    </div>
@elseif (session()->has('failed'))
    <div class="container container--narrow">
        <div class="alert alert-danger text-center">
            {{ session('failed') }}
        </div>
    </div>
@endif

<div class="container py-md-5">
    <div class="row align-items-center">
        <div class="col-lg-7 py-3 py-md-5">
            <h1 class="display-4">Welcome Back!</h1>
            <p class="lead text-muted">Log in to continue fighting against cholera. Access your dashboard, track progress, and contribute to the cause.</p>
        </div>
        <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
            <form action="/login" method="POST" id="login-form">
                @csrf
                <div class="form-group">
                    <label for="email-login" class="text-muted mb-1"><small>Email</small></label>
                    <input value="{{ old('email') }}" name="email" id="email" class="form-control" type="email" placeholder="Enter your email" autocomplete="off" />
                    @error('email')
                        <p class="m-0 small alert alert-danger shadow-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password-login" class="text-muted mb-1"><small>Password</small></label>
                    <input name="password" id="password" class="form-control" type="password" placeholder="Enter your password" />
                    @error('password')
                        <p class="m-0 small alert alert-danger shadow-sm">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Log in</button>
            </form>
        </div>
    </div>
</div>

@include('components.footer')
