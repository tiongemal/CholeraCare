@include('components.header')
<div class="container">
    <h1>Sync Logs</h1>
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
</div>
@include('components.footer')
