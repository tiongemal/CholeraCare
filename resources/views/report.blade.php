@include('components.header')
@if (session()->has('success'))
    <div class="container container--narrow">
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    </div>
@elseif (session()->has('failed'))
    <div class="container container--narrow">
        <div class="alert alert-danger text-center">
            {{ session('failed') }}
        </div>
    </div>
@endif

<div class="container mt-5">
    <h2>Cholera Report Form</h2>
    <form action="/reportsubmit" method="POST">
        @csrf

        <!-- Report Date (hidden input) -->
        @php
        $currentDate = now()->toDateString(); // Get the current date in 'YYYY-MM-DD' format
        @endphp
        <input type="hidden" id="reportDate" name="reported_at" value="{{ $currentDate }}" required>

        @error('reported_at')
            <p class="m-0 small alert alert-danger shadow-sm">
                {{ $message }}
            </p>
        @enderror

        <!-- Case Status (Dropdown) -->
        <div class="mb-3">
            <label for="caseStatus" class="form-label">Case Status</label>
            <select class="form-control" id="caseStatus" name="case_status" required>
                <option value="" disabled selected>Select case status</option>
                <option value="suspected">Suspected</option>
                <option value="confirmed">Confirmed</option>
            </select>
            @error('case_status')
                <p class="m-0 small alert alert-danger shadow-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Patient Age -->
        <div class="mb-3">
            <label for="patientAge" class="form-label">Patient Age</label>
            <input type="number" class="form-control" id="patientAge" name="patient_age" placeholder="Enter patient's age" required>
            @error('patient_age')
                <p class="m-0 small alert alert-danger shadow-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Patient Gender (Dropdown) -->
        <div class="mb-3">
            <label for="patientGender" class="form-label">Patient Gender</label>
            <select class="form-control" id="patientGender" name="patient_gender" required>
                <option value="" disabled selected>Select patient gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
            @error('patient_gender')
                <p class="m-0 small alert alert-danger shadow-sm">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn btn-primary">Submit Report</button>
    </form>
</div>

@include('components.footer')
