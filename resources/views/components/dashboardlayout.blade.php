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
        <button class="burger-icon" id="burgerIcon">
          <i class="fas fa-bars"></i>
        </button>
        <h4 class="app-name ml-2">CholeraCare</h4>
      </div>
    </nav>

    <!-- Sidebar -->
    <nav id="sidebarMenu" class="sidebar-custom">
      <div class="p-3">
        <h4 class="text-white app-name">Menu</h4>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link text-white active" href="/dashboard">
              <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white active" href="/register">
              <i class="fas fa-user-alt"></i> Register user
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/users">
              <i class="fas fa-users"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/reports">
              <i class="fas fa-file-alt"></i> Reports
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/charts">
              <i class="fas fa-chart-bar"></i> Charts
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-white" href="/settings">
              <i class="fas fa-cog"></i> Settings
            </a>
          </li>
        </ul>
      </div>
      <button class="btn btn-light sign-out">Sign Out</button>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="content">
      <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
          <h1 class="h2">Admin Dashboard</h1>
        </div>

        <div class="row">
            <div class="col-md-4">
              <div class="dashboard-box bg-primary text-white p-3 mb-3 text-center">
                <h2><i class="fas fa-users"></i> {{ $userCount }}</h2>
                <p>Number of Users</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="dashboard-box bg-success text-white p-3 mb-3 text-center">
                <h2><i class="fas fa-file-alt"></i> {{ $reportCount }}</h2>
                <p>Number of Reports</p>
              </div>
            </div>
            <div class="col-md-4">
              <div class="dashboard-box bg-warning text-white p-3 mb-3 text-center">
                <h2><i class="fas fa-sync"></i> {{ $syncCount }}</h2>
                <p>Number of Data Syncs</p>
              </div>
            </div>
          </div>

          <!-- User Table (Only Active Users) -->
          <div class="container">
            <h1>Active User Management</h1>

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
    </script>
  </body>
</html>
