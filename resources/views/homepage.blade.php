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

<div class="container py-md-5 container--narrow">
    @auth
        <div class="text-center mb-4">
            <h1 class="display-4">Hello, <strong>{{ auth()->user()->fullname }}</strong></h1>
            <p class="lead">Welcome back! Here's what you can do:</p>
        </div>

        <div class="row text-center">
            @if (auth()->user()->role === 'admin')
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Admin Dashboard</h5>
                            <p class="card-text">Manage users and view system analytics.</p>
                            <a href="/dashboard/admin" class="btn btn-sm btn-success mr-2"> Dashboard</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">User Management</h5>
                            <p class="card-text">View and manage all users.</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-success mr-2">Manage Users</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-info">
                        <div class="card-body">
                            <h5 class="card-title">field reports</h5>
                            <p class="card-text">View available field reports </p>
                            <a href="/reports" class="btn btn-sm btn-success mr-2">Reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">locations</h5>
                            <p class="card-text">View available field locations </p>
                            <a href="/locations" class="btn btn-sm btn-success mr-2">locations</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">View Supplies</h5>
                            <p class="card-text">Check your supplies in stock.</p>
                            <a href="/suppliesShow" class="btn btn-sm btn-success mr-2">View Supplies</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Restock Requests</h5>
                            <p class="card-text">Check your supply restock request.</p>
                            <a href="/restocknotifications" class="btn btn-sm btn-success mr-2">View Requests</a>
                        </div>
                    </div>
                </div>
            @elseif (auth()->user()->role === 'hq_staff')
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Reports Overview</h5>
                            <p class="card-text">View field staff collected reports.</p>
                            <a href="/reports" class="btn btn-success btn-sm">View Reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Report Charts</h5>
                            <p class="card-text">view field reports charts.</p>
                            <a href="/charts" class="btn btn-success btn-sm">view charts</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Restock Requests</h5>
                            <p class="card-text">Check your supply restock request.</p>
                            <a href="/restocknotifications" class="btn btn-sm btn-success mr-2">View Requests</a>
                        </div>
                    </div>
                </div>
            @elseif (auth()->user()->role === 'field_staff')
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Submit Report</h5>
                            <p class="card-text">Report new cholera cases in your area.</p>
                            <a href="/reportform" class="btn btn-sm btn-success mr-2">Go to Report Form</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">Sync Reports</h5>
                            <p class="card-text">sync reports with HQ server</p>
                            <a href="/data-sync" class="btn btn-sm btn-success mr-2">Sync reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">View My Reports</h5>
                            <p class="card-text">Check your submitted reports and their status.</p>
                            <a href="/report" class="btn btn-sm btn-success mr-2">View Reports</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-dark">
                        <div class="card-body">
                            <h5 class="card-title">View Supplies</h5>
                            <p class="card-text">Check your supplies in stock.</p>
                            <a href="/suppliesShow" class="btn btn-sm btn-success mr-2">View Supplies</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="text-center mt-4">
            <form action="/logout" method="POST" class="d-inline">
                @csrf
              <button class="btn btn-outline-danger">Sign Out</button>
            </form>
        </div>

    @else
        <div class="text-center">
            <h1>Welcome to CholeraCare</h1>
            <p>Please log in to access your feed and manage your account.</p>
        </div>
    @endauth


</div>

@include('components.footer')
