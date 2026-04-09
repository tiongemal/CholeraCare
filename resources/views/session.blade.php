@include('components.header')

<div class="container">
    <h2>User Session Data</h2>
    <ul>
        <li><strong>Username:</strong> {{ $username }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
      </ul>
    @if($location)
    <p>Location: {{ $location->location_name }}</p> <!-- Assuming 'name' is a column in your locations table -->
@else
    <p>No location assigned</p>
@endif
</div>
