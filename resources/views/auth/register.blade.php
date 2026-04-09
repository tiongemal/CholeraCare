@include('components.header')
    @if (session()->has('success'))
        <div class=" container container--narrow">

            <div class="alert alert-success text-center">
                {{session('success')}}

            </div>

        </div>
    @elseif (session()->has('failed'))
    <div class=" container container--narrow">

        <div class="alert alert-danger text-center">
            {{session('failed')}}

        </div>

    </div>
    @endif
    <div class="container py-md-5">
        <div class="row align-items-center">
            <div class="col-lg-7 py-3 py-md-5">
                <h1 class="display-4">Join the Fight Against Cholera</h1>
                <p class="lead text-muted">Are you concerned about the spread of cholera in your community? We believe that timely information, real-time data, and proactive engagement are key to controlling and preventing cholera outbreaks. Join us in making a difference.</p>
            </div>
            <div class="col-lg-5 pl-lg-5 pb-3 py-lg-5">
                <form action="{{ route('register.post') }}" method="POST" id="registration-form">
                    @csrf
                    <div class="form-group">
                        <label for="fullname-register" class="text-muted mb-1"><small>Fullname</small></label>
                        <input value="{{ old('fullname') }}" name="fullname" id="fullname-register" class="form-control" type="text" placeholder="Pick a fullname" autocomplete="off" />
                        @error('fullname')
                            <p class="m-0 small alert alert-danger shadow-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email-register" class="text-muted mb-1"><small>Email</small></label>
                        <input value="{{ old('email') }}" name="email" id="email-register" class="form-control" type="text" placeholder="you@example.com" autocomplete="off" />
                        @error('email')
                            <p class="m-0 small alert alert-danger shadow-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role-register" class="text-muted mb-1"><small>Role</small></label>
                        <select class="form-control" id="userRole" name="role">
                            <option value="hq_staff">HQ Staff</option>
                            <option value="field_staff">Field Staff</option>
                        </select>
                        @error('role')
                            <p class="m-0 small alert alert-danger shadow-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <div>
                        <label for="role-register" class="text-muted mb-1"><small>Location</small></label>
                        <select class="form-control" name="location_id" id="location_id" required>
                            <option value="">Select Location</option>
                            @foreach($locations as $location)
                                <option value="{{ $location->location_id }}" {{ old('location_id') == $location->location_id ? 'selected' : '' }}>
                                    {{ $location->location_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('location_id')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-register" class="text-muted mb-1"><small>Password</small></label>
                        <input name="password" id="password-register" class="form-control" type="password" placeholder="Create a password" />
                        @error('password')
                            <p class="m-0 small alert alert-danger shadow-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password-register-confirm" class="text-muted mb-1"><small>Confirm Password</small></label>
                        <input name="password_confirmation" id="password-register-confirm" class="form-control" type="password" placeholder="Confirm password" />
                        @error('password_confirmation')
                            <p class="m-0 small alert alert-danger shadow-sm">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                    <!-- Location select dropdown -->


                    <button type="submit" class="py-3 mt-4 btn btn-lg btn-success btn-block">Sign up for CholeraCare</button>
                </form>
            </div>
        </div>
    </div>
@include('components.footer')
