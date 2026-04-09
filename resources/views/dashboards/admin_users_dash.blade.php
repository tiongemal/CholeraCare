@include('components.header')

<!-- Main Content -->
<div id="mainContent" class="content">
    <div class="container-fluid">
        <!-- User Table (Only Active Users) -->
        <div class="container">
            <h1>User Management</h1>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <!-- Search Bar -->
            <form method="GET" action="{{ route('admin.users.search') }}" id="searchForm" class="form-inline my-3">
                <input
                    class="form-control mr-sm-2"
                    type="search"
                    name="search"
                    id="searchInput"
                    placeholder="Search users by name or email"
                    aria-label="Search"
                    value="{{ request('search') }}"
                />
                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
            </form>

            <!-- User Table -->
            <div id="userTable">
                @include('admin.users.table', ['users' => $users])
            </div>
        </div>
    </div>
</div>

@include('components.footer')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Handle search form submission
        $('#searchForm').on('submit', function(event) {
            event.preventDefault();
            fetchUsers();
        });

        // Handle pagination clicks
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault();
            var page = $(this).attr('href').split('page=')[1];
            fetchUsers(page);
        });

        // Fetch users based on search and page
        function fetchUsers(page = 1) {
            var query = $('#searchInput').val();
            $.ajax({
                url: "{{ route('admin.users.search') }}",
                method: 'GET',
                data: { search: query, page: page },
                success: function(response) {
                    $('#userTable').html(response);
                },
                error: function(xhr) {
                    console.error('Error fetching users:', xhr);
                }
            });
        }
    });
</script>
