@if(session('success'))

<div class="alert alert-success alert-dismissible fade show">

    <i class="bi bi-check-circle"></i>

    {{ session('success') }}

    <button
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif

@if(session('error'))

<div class="alert alert-danger alert-dismissible fade show">

    <i class="bi bi-exclamation-circle"></i>

    {{ session('error') }}

    <button
        class="btn-close"
        data-bs-dismiss="alert">
    </button>

</div>

@endif