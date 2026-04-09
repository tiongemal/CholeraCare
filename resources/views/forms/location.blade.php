@include('components.header')

<div class="container">
    <h1>Add New Location</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('locations.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="location_name">Location Name</label>
            <input type="text" name="location_name" class="form-control @error('location_name') is-invalid @enderror" id="location_name" value="{{ old('location_name') }}" required>
            @error('location_name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="region">Region</label>
            <select name="region" class="form-control @error('region') is-invalid @enderror" id="region" required>
                <option value="">Select Region</option>
                <option value="Northern Region" {{ old('region') == 'Northern Region' ? 'selected' : '' }}>Northern Region</option>
                <option value="Central Region" {{ old('region') == 'Central Region' ? 'selected' : '' }}>Central Region</option>
                <option value="Southern Region" {{ old('region') == 'Southern Region' ? 'selected' : '' }}>Southern Region</option>
            </select>

            @error('region')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Location</button>
    </form>
</div>
@include('components.footer')
