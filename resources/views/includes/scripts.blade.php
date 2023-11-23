{{-- jQuery --}}
<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>

{{-- Bootstrap 5.3.2 JS & Popper --}}
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

{{-- Livewire --}}
@livewireScripts

{{-- TinyCME --}}
<script src="https://cdn.tiny.cloud/1/reyjnydujgxgiq0h3lhij1ev69aatc5aym5kjrnxaz417jg0/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>

{{-- AOS --}}
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
  AOS.init();
</script>

{{-- Custom JS --}}
{{-- @vite('resources/js/app.js') --}}
<script src="{{ asset('js/main.js') }}"></script>
