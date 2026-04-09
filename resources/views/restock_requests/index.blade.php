@include('components.header')
<div class="container">
    <h1>Restock Requests</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Supply Name</th>
                <th>Requested By</th>
                <th>Quantity Left</th>
                <th>Location</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($restockRequests as $request)
                <tr>
                    <td>{{ $request->supply->supply_name }}</td>
                    <td>{{ $request->user->fullname }}</td>
                    <td>{{ $request->quantity_left }}</td>
                    <td>{{ $request->location->location_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($request->created_at)->format('F j, Y \a\t h:i A') }}</td>
                    <td>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-success btn-sm">Restock</button>
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
            @if ($restockRequests->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $restockRequests->previousPageUrl() . '&active_section=location' }}">Prev</a>
                </li>
            @endif

            <!-- Pagination Elements -->
            @for ($i = 1; $i <= $restockRequests->lastPage(); $i++)
                <li class="page-item {{ $i == $restockRequests->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $restockRequests->url($i) . '&active_section=location' }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Next Page Link -->
            @if ($restockRequests->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $restockRequests->nextPageUrl() . '&active_section=location' }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </div>
</div>
@include('components.footer')
