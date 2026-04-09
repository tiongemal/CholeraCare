<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #dc3545; /* Red color for sidebar */
            padding-top: 20px;
            transition: width 0.3s;
        }
        .sidebar.collapsed {
            width: 80px; /* Width when collapsed */
        }
        .sidebar a {
            color: rgb(0, 0, 0);
            padding: 10px 15px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .sidebar a:hover {
            background-color: #b52a34;
        }
        .menu-text {
            margin-left: 15px;
            transition: opacity 0.3s;
        }
        .sidebar.collapsed .menu-text {
            display: none; /* Hide text when collapsed */
        }
        .sidebar.collapsed a i {
            margin-right: 0; /* No margin for icons when collapsed */
        }
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: margin-left 0.3s;
        }
        .content.collapsed {
            margin-left: 80px; /* Adjust margin when sidebar is collapsed */
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar bg-danger" id="sidebar">
    <a href="#" class="btn btn-light" onclick="toggleMenu()">
        <i class="fas fa-bars"></i>
        <span class="menu-text">Menu</span>
    </a>
    <a href="#">
        <i class="fas fa-tachometer-alt"></i>
        <span class="menu-text">Dashboard</span>
    </a>
    <a href="#">
        <i class="fas fa-users"></i>
        <span class="menu-text">Users</span>
    </a>
    <a href="#">
        <i class="fas fa-chart-line"></i>
        <span class="menu-text">Sales</span>
    </a>
    <a href="#">
        <i class="fas fa-file-alt"></i>
        <span class="menu-text">Reports</span>
    </a>
</div>

<!-- Content -->
<div class="content" id="content">
    <div class="container">
        <h1 class="mb-4">Admin Dashboard</h1>

        <!-- Dummy Statistics -->
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-primary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Users</h5>
                        <p class="card-text">{{ $data['users'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Sales</h5>
                        <p class="card-text">{{ $data['sales'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-info mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Revenue</h5>
                        <p class="card-text">${{ $data['revenue'] }}</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Growth</h5>
                        <p class="card-text">{{ $data['growth'] }}%</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row">
            <div class="col-lg-6">
                <canvas id="salesChart"></canvas>
            </div>
            <div class="col-lg-6">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Toggle Sidebar
    function toggleMenu() {
        document.getElementById('sidebar').classList.toggle('collapsed');
        document.getElementById('content').classList.toggle('collapsed');
    }

    // Charts
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');

    const salesChart = new Chart(salesCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'Sales',
                data: [12, 19, 3, 5, 2],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const revenueChart = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May'],
            datasets: [{
                label: 'Revenue',
                data: [500, 1000, 1500, 2000, 3000],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
</body>
</html>
