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

{{-- Bootstrap Multiselect --}}
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

{{-- Livewire --}}
@livewireScripts
@stack('scripts')

{{-- Custom JS --}}
<script src="{{ asset('js/main.js') }}"></script>

{{-- Vite --}}
@vite('resources/js/app.js')
