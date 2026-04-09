<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>CholeraCare Dashboard</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-LtrjvnR4/JBMLp25VtlNV2Qx1KlfLkq6i8bQURoQu5xtv5c36w5MfQrr0hpAW2GH"
      crossorigin="anonymous"
    />
    <script
      defer
      src="https://use.fontawesome.com/releases/v5.5.0/js/all.js"
      integrity="sha384-GqVMZRt5Gn7tB9D9q7ONtcp4gtHIUEW/yG7h98J7IpE3kpi+srfFyyB/04OV6pG0"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="/main.css" />
</head>
<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-custom">
        <div class="container-fluid d-flex justify-content-between">
            <h1>
            <button class="burger-icon" id="burgerIcon">
                <i class="fas fa-bars"></i>
            </button>
            </h1>
            <h2>
                @if(auth()->check())
                    {{ auth()->user()->fullname }} dashboard
                @else
                    Guest
                @endif
            </h2>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar-custom">
        <div class="p-3">
            <h4 class="text-white app-name">Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link text-white active" href="#" onclick="showSection('dashboard')">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('location')">
                        <i class="fas fa-map-marker-alt"></i> Location
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('users')">
                        <i class="fas fa-users"></i> Users
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('reports')">
                        <i class="fas fa-file-alt"></i> Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#" onclick="showSection('syncs')">
                        <i class="fas fa-sync"></i> Sync Logs
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="/home">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
            </ul>
        </div>
        <button class="btn btn-light sign-out">Sign Out</button>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="content">
        <div class="container-fluid">

            <!-- Dashboard Section -->
            <div id="dashboard" class="section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="dashboard-box bg-primary text-white p-3 mb-3 text-center" onclick="showSection('users')" style="cursor: pointer;">
                            <h2><i class="fas fa-users"></i> {{ $userCount }}</h2>
                            <p>Number of Users</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-box bg-success text-white p-3 mb-3 text-center" onclick="showSection('reports')" style="cursor: pointer;">
                            <h2><i class="fas fa-file-alt"></i> {{ $reportCount }}</h2>
                            <p>Number of Reports</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="dashboard-box bg-warning text-white p-3 mb-3 text-center" onclick="showSection('users')" style="cursor: pointer;">
                            <h2><i class="fas fa-sync"></i> {{ $syncCount }}</h2>
                            <p>Number of Data Syncs</p>
                        </div>
                    </div>
                </div>
                <h1>Active Users</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeUsers as $user)
                            <tr>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center mt-4">
                    <ul class="pagination">

                        <!-- Previous Page Link -->
                        @if ($activeUsers->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">Prev</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $activeUsers->previousPageUrl() }}">Prev</a>
                            </li>
                        @endif

                        <!-- Pagination Elements -->
                        @for ($i = 1; $i <= $activeUsers->lastPage(); $i++)
                            <li class="page-item {{ $i == $activeUsers->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $activeUsers->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        <!-- Next Page Link -->
                        @if ($activeUsers->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $activeUsers->nextPageUrl() }}">Next</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Next</span>
                            </li>
                        @endif

                    </ul>
                </div>
                <a href="/suppliesShow" class="see-all text-white">
                    <button class="btn btn-sm btn-success mr-2">
                        view supplies
                    </button>
                </a>

                <br>
                <br>

            </div>

            <!-- User Management Section -->
            <div id="users" class="section" style="display: none;">
                <h1>Active Users Management</h1>

                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeUsers as $user)
                            <tr>
                                <td>{{ $user->fullname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->role }}</td>
                                <td>{{ $user->status }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination Links -->
             <div class="d-flex justify-content-center mt-4">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($activeUsers->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Prev</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $activeUsers->previousPageUrl() . '&active_section=location' }}">Prev</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $activeUsers->lastPage(); $i++)
                        <li class="page-item {{ $i == $activeUsers->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $activeUsers->url($i) . '&active_section=location' }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($activeUsers->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $activeUsers->nextPageUrl() . '&active_section=location' }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
            </div>


                    <a href="/dashboard/admin/users" class="see-all text-white">
                        <button class="btn btn-sm btn-success mr-2">
                            See all
                        </button>
                    </a>
            </div>

            <!-- Placeholder for Other Sections -->
            <div id="location" class="section" style="display: none;">
                <h1>Locations</h1>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Location Name</th>
                        <th>Region</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($locations as $location)
                        <tr>
                            <td>{{ $loop->iteration + ($locations->currentPage() - 1) * $locations->perPage() }}</td>
                            <td>{{ $location->location_name }}</td>
                            <td>{{ $location->region }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No locations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <a href="/locations" class="see-all text-white">
                <button class="btn btn-sm btn-success mr-2">
                    add location
                </button>
            </a>
             <!-- Pagination Links -->
             <div class="d-flex justify-content-center mt-4">
                <ul class="pagination">
                    <!-- Previous Page Link -->
                    @if ($locations->onFirstPage())
                        <li class="page-item disabled">
                            <span class="page-link">Prev</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $locations->previousPageUrl() . '&active_section=location' }}">Prev</a>
                        </li>
                    @endif

                    <!-- Pagination Elements -->
                    @for ($i = 1; $i <= $locations->lastPage(); $i++)
                        <li class="page-item {{ $i == $locations->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $locations->url($i) . '&active_section=location' }}">{{ $i }}</a>
                        </li>
                    @endfor

                    <!-- Next Page Link -->
                    @if ($locations->hasMorePages())
                        <li class="page-item">
                            <a class="page-link" href="{{ $locations->nextPageUrl() . '&active_section=location' }}">Next</a>
                        </li>
                    @else
                        <li class="page-item disabled">
                            <span class="page-link">Next</span>
                        </li>
                    @endif
                </ul>
            </div>



        </div>

            <div id="reports" class="section" style="display: none;">
                <h1>Reports</h1>
                <!-- Reports content here -->
                <div class="table-responsive">
                    <h3>Case Reports</h3>
                    <table class="table table-bordered mt-4">
                        <thead class="thead-light">
                            <tr>
                                <th>Case ID</th>
                                <th>Status</th>
                                <th>Patient Age</th>
                                <th>Patient Gender</th>
                                <th>Supplies Used</th>
                                <th>Reported At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($reports as $report)
                            <tr>
                                <td>{{ $report->case_id }}</td>
                                <td>{{ $report->case_status }}</td>
                                <td>{{ $report->patient_age }}</td>
                                <td>{{ $report->patient_gender }}</td>
                                <td>{{ $report->supplies_used }}</td>
                                <td>{{ $report->reported_at }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="/reports" class="see-all text-white">
                        <button class="btn btn-sm btn-success mr-2">
                            See all
                        </button>
                    </a>
                </div>
            </div>


            <div id="syncs" class="section" style="display: none;">
                <h1>Sync Logs</h1>
                <!-- Reports content here -->
                <div class="table-responsive">
                    <h3>Sync Logs</h3>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field Worker</th>
                                <th>Last Sync</th>
                                <th>Location ID</th> <!-- Assuming you added location_id in SyncLog -->
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($syncLogs as $log)
                                <tr>
                                    <td>{{ $log->fieldWorker->name ?? 'N/A' }}</td> <!-- Display field worker name -->
                                    <td>{{ $log->last_sync }}</td>
                                    <td>{{ $log->location_id }}</td> <!-- Display location ID -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <a href="/sync-logs" class="see-all text-white">
                        <button class="btn btn-sm btn-success mr-2">
                            See all
                        </button>
                    </a>
                </div>
            </div>

            <div id="charts" class="section" style="display: none;">
                <h1>Charts</h1>
                <!-- Charts content here -->
            </div>

            <div id="settings" class="section" style="display: none;">
                <h1>Settings</h1>
                <!-- Settings content here -->
            </div>
        </div>
    </div>

    @include('components.footer')

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Toggle the sidebar
        document.getElementById('burgerIcon').addEventListener('click', function () {
            var sidebar = document.getElementById('sidebarMenu');
            var content = document.getElementById('mainContent');
            sidebar.classList.toggle('closed');
            content.classList.toggle('full-width');

            // Change the icon based on the sidebar state
            var icon = this.querySelector('i');
            if (sidebar.classList.contains('closed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });

        // Function to show the selected section
@php
    $activeSection = request('active_section', 'dashboard'); // Default to 'dashboard'
@endphp

function showSection(sectionId) {
    console.log(`Showing section: ${sectionId}`); // Debugging line
    const sections = document.querySelectorAll('.section');
    sections.forEach(section => {
        section.style.display = 'none';
    });

    document.getElementById(sectionId).style.display = 'block';

    // Highlight active menu item
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.classList.remove('active');
    });
    document.querySelector(`a[onclick="showSection('${sectionId}')"]`).classList.add('active');
}
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevents the form from submitting and reloading the page
});


    // Initial display based on active section
    showSection('{{ $activeSection }}');
    </script>
</body>
</html>
