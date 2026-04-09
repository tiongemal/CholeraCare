@include('components.header')
<div class="container">
    <h1>Add New Supply</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('supplies.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="supply_name" class="form-label">Supply Name</label>
            <input type="text" class="form-control" id="supply_name" name="supply_name" required>
        </div>
        <div class="mb-3">
            <label for="total_quantity" class="form-label">Total Quantity</label>
            <input type="number" class="form-control" id="total_quantity" name="total_quantity" required min="0">
        </div>
        <button type="submit" class="btn btn-primary">Edit Supply</button>
    </form>
</div>

@include('components.footer')
