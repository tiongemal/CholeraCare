@include('components.header')

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<div class="container-fluid">

    <div class="row min-vh-100 align-items-center justify-content-center bg-light" id="what-is-cholera">
        <div class="col-lg-6 text-center">
            <h1 class="display-4 mb-4">What is Cholera?</h1>
            <p class="lead mb-4">Cholera is an acute diarrheal illness caused by infection of the intestine with the bacterium <strong>Vibrio cholerae</strong>. It can lead to severe dehydration and even death if not treated promptly.</p>
            <a href="#symptoms" class="btn btn-primary btn-lg">Next: Symptoms</a>
        </div>
    </div>

    <div class="row min-vh-100 align-items-center justify-content-center bg-warning text-white" id="symptoms">
        <div class="col-lg-6 text-center">
            <h1 class="display-4 mb-4">Symptoms of Cholera</h1>
            <ul class="list-group list-group-flush mb-4">
                <li class="list-group-item bg-warning d-flex align-items-center">
                    <i class="fas fa-water fa-lg me-3"></i> Profuse watery diarrhea
                </li>
                <li class="list-group-item bg-warning d-flex align-items-center">
                    <i class="fas fa-vial fa-lg me-3"></i> Vomiting
                </li>
                <li class="list-group-item bg-warning d-flex align-items-center">
                    <i class="fas fa-dumbbell fa-lg me-3"></i> Muscle cramps
                </li>
                <li class="list-group-item bg-warning d-flex align-items-center">
                    <i class="fas fa-tint fa-lg me-3"></i> Dehydration
                </li>
                <li class="list-group-item bg-warning d-flex align-items-center">
                    <i class="fas fa-bolt fa-lg me-3"></i> Electrolyte imbalance
                </li>
            </ul>
            <a href="#prevention" class="btn btn-light btn-lg">Next: Prevention and Treatment</a>
        </div>
    </div>

    <div class="row min-vh-100 align-items-center justify-content-center bg-success text-white" id="prevention">
        <div class="col-lg-6 text-center">
            <h1 class="display-4 mb-4">Prevention and Treatment</h1>
            <p class="lead mb-4">Cholera can be prevented by ensuring access to clean drinking water, proper sanitation, and hygiene practices. Treatment includes rehydration therapy, and in severe cases, antibiotics may be prescribed.</p>
            <a href="#what-is-cholera" class="btn btn-light btn-lg">Back to Top</a>
        </div>
    </div>

</div>

@include('components.footer')
