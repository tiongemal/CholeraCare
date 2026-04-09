
    @include('components.header')

    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Field Dashboard</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-light">Dashboard</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Profile</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Settings</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Notifications</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Logout</a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
            </nav>

            <div class="container-fluid">
                <h1 class="mt-4">Dashboard Content</h1>
                <p>Your dashboard content goes here.</p>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>


    @include('components.footer')

