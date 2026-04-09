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
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->fullname }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
                <td>
                    <form action="{{ route('admin.users.toggleStatus', $user->user_id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-success' : 'btn-danger' }}">
                            {{ ucfirst($user->status) }}
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Pagination Links -->
<div class="d-flex justify-content-center mt-4">
    <ul class="pagination">

        <!-- Previous Page Link -->
        @if ($users->onFirstPage())
            <li class="page-item disabled">
                <span class="page-link">Prev</span>
            </li>
        @else
            <li class="page-item">
                <a class="page-link" href="{{ $users->previousPageUrl() }}">Prev</a>
            </li>
        @endif

        <!-- Pagination Elements -->
        @for ($i = 1; $i <= $users->lastPage(); $i++)
            <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
            </li>
        @endfor

        <!-- Next Page Link -->
        @if ($users->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
            </li>
        @else
            <li class="page-item disabled">
                <span class="page-link">Next</span>
            </li>
        @endif

    </ul>
</div>
