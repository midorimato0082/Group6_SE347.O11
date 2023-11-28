@if (session('fail') ?? session('success'))
    <div class="alert {{session('fail') ? 'alert-danger' : 'alert-success' }} mb-4">{{ session('fail') ?? session('success')}}</div>
@endif