<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{asset('js/popper.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>

<script src="{{ asset('admin-styles/js/sweetalert2.js') }}"></script>
<script src="{{ asset('admin-styles/js/save-trait.js') }}"></script>


<script  src="{{asset('admin-styles/plugins\air-date-picker\js\datepicker.min.js')}}"></script>
<script>
    $(document).ready(function () {
        $('[name=search]').on('change', function () {
            $('#search').trigger('submit');
        });
    });
</script>

@stack('scripts')
