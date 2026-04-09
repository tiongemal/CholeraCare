@include('components.header')

<div class="container">
    <h1>Cholera Daily Reports</h1>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('reportTable') }}">
        <div class="row mb-3">
            <div class="col">
                <select id="caseFilter" name="case_filter" class="form-control">
                    <option value="">Filter by case type</option>
                    <option value="suspected" {{ request()->case_filter == 'suspected' ? 'selected' : '' }}>Suspected Cases</option>
                    <option value="confirmed" {{ request()->case_filter == 'confirmed' ? 'selected' : '' }}>Confirmed Cases</option>
                </select>
            </div>

            <!-- Location Filter (only show for admins) -->
            @if(auth()->user()->role !== 'field_staff')
                <div class="col">
                    <select name="location" class="form-control">
                        <option value="">Select Location</option>
                        @foreach($locations as $location)
                            <option value="{{ $location->location_id }}"
                                {{ request()->location == $location->location_id ? 'selected' : '' }}>
                                {{ $location->location_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col">
                <input type="date" name="report_date" class="form-control" placeholder="Filter by Date" value="{{ request()->report_date }}">
            </div>

            <div class="col">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Sorting Links -->
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>User</th>
                <th><a href="{{ route('reportTable', array_merge(request()->all(), ['sort_field' => 'location', 'sort_order' => request()->get('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Location</a></th>
                <th><a href="{{ route('reportTable', array_merge(request()->all(), ['sort_field' => 'report_date', 'sort_order' => request()->get('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Report Date</a></th>
                <th class="suspected-column"><a href="{{ route('reportTable', array_merge(request()->all(), ['sort_field' => 'suspected_cases', 'sort_order' => request()->get('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Suspected Cases</a></th>
                <th class="confirmed-column"><a href="{{ route('reportTable', array_merge(request()->all(), ['sort_field' => 'confirmed_cases', 'sort_order' => request()->get('sort_order') === 'asc' ? 'desc' : 'asc'])) }}">Confirmed Cases</a></th>
            </tr>
        </thead>
        <tbody>
            @foreach($reports as $report)
                <tr>
                    <td>{{ $report->fieldWorker ? $report->fieldWorker->fullname : 'No field worker' }}</td>
                    <td>{{ $report->location ? $report->location->location_name : 'No location' }}</td>
                    <td>{{ $report->report_date }}</td>
                    <td class="suspected-column">{{ $report->suspected_cases }}</td>
                    <td class="confirmed-column">{{ $report->confirmed_cases }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination Links -->
    {{ $reports->appends(request()->all())->links('pagination::bootstrap-4') }}
</div>

@include('components.footer')

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const caseFilter = document.getElementById('caseFilter');
        const suspectedColumns = document.querySelectorAll('.suspected-column');
        const confirmedColumns = document.querySelectorAll('.confirmed-column');

        function toggleColumns() {
            const filterValue = caseFilter.value;

            if (filterValue === 'suspected') {
                suspectedColumns.forEach(column => column.style.display = '');
                confirmedColumns.forEach(column => column.style.display = 'none');
            } else if (filterValue === 'confirmed') {
                confirmedColumns.forEach(column => column.style.display = '');
                suspectedColumns.forEach(column => column.style.display = 'none');
            } else {
                suspectedColumns.forEach(column => column.style.display = '');
                confirmedColumns.forEach(column => column.style.display = '');
            }
        }

        // Run on page load
        toggleColumns();

        // Run on filter change
        caseFilter.addEventListener('change', toggleColumns);
    });
</script>
