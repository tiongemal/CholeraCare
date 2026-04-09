@include('components.header')
<div class="container">
    <h1>Supplies List</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Supply Name</th>
                <th>Total Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($supplies as $supply)
                <tr>
                    <td>{{ $supply->supply_name }}</td>
                    <td>{{ $supply->total_quantity }}</td>
                    <td>
                        @if (auth()->user()->role === 'admin' || auth()->user()->role === 'HQ')
                            <a href="{{ route('supplies.edit', $supply->supply_id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action='{{ route('supplies.destroy', $supply->supply_id) }}' method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @else
                            <form action="/restock-requests" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="supply_id" value="{{ $supply->supply_id }}">
                                <button type="submit" class="btn btn-sm btn-success mr-2">Request Restock</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'HQ')
        <a href="/supplies/create">
            <button type="submit" class="btn btn-primary">Add Supplies</button>
        </a>
    @else
        <input type="hidden">
    @endif


    <div class="d-flex justify-content-center mt-4">
        <ul class="pagination">
            <!-- Previous Page Link -->
            @if ($supplies->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $supplies->previousPageUrl() . '&active_section=location' }}">Prev</a>
                </li>
            @endif

            <!-- Pagination Elements -->
            @for ($i = 1; $i <= $supplies->lastPage(); $i++)
                <li class="page-item {{ $i == $supplies->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $supplies->url($i) . '&active_section=location' }}">{{ $i }}</a>
                </li>
            @endfor

            <!-- Next Page Link -->
            @if ($supplies->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $supplies->nextPageUrl() . '&active_section=location' }}">Next</a>
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
