<!-- Scripts -->

<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
{{-- <script src="{{ mix('js/app.js') }}"></script> --}}


{{-- <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>--}}
{{-- <script src="{{ asset('js/popper.js') }}" type="text/javascript"></script>  --}}

<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>


<script src="{{ asset('js/script.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="js/sweetalert.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@stack('scripts')
