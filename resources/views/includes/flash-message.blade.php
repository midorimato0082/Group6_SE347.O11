@if (Session::has('fail'))
    <div class="alert alert-danger mb-4">{{ session('fail') }}</div>
@endif

@if (Session::has('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif