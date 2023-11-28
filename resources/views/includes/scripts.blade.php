{{-- jQuery --}}
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

{{-- Bootstrap 5.3.2 JS & Popper --}}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{{-- CKEditor 5 --}}
<script src="{{ asset('js/ckeditor.js') }}"></script>

{{-- Bootstrap Tags Input --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

{{-- AOS --}}
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>

{{-- Livewire --}}
@livewireScripts
@stack('scripts')

{{-- Custom JS --}}
<script src="{{ asset('js/main.js') }}"></script>
