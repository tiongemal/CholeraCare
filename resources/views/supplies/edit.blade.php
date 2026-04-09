@include('components.header')

<div class="container">
    <h1>Edit Supply: {{ $supply->supply_name }}</h1>

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supplies.update', $supply->supply_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="supply_name">Supply Name</label>
            <input type="text" class="form-control" id="supply_name" name="supply_name" value="{{ old('supply_name', $supply->supply_name) }}" required>
        </div>

        <div class="form-group">
            <label for="total_quantity">Total Quantity</label>
            <input type="number" class="form-control" id="total_quantity" name="total_quantity" value="{{ old('total_quantity', $supply->total_quantity) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Supply</button>
        <a href="{{ route('supplies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@include('components.footer')
