<script src="{{ asset('admin-styles/js/vendors/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('admin-styles/js/vendors/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin-styles/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('admin-styles/js/custom.js') }}"></script>
<script src="{{ asset('admin-styles/js/edit-img.js') }}"></script>
<script src="{{ asset('admin-styles/js/sweetalert2.js') }}"></script>
<script src="{{ asset('admin-styles/js/save-trait.js') }}"></script>
<script src="{{asset('admin-styles/plugins/datatable/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('admin-styles/plugins/datatable/dataTables.bootstrap4.min.js') }}"></script>


<script src="{{asset('admin-styles/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{asset('admin-styles/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('admin-styles/plugins/air-date-picker/js/datepicker.min.js')}}"></script>
<script src="{{asset('admin-styles/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js')}}"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<script>
    $('.modal').on('hidden.bs.modal', function () {
        $('.form-modal').html(' <img class="preload-category" src="{{asset("admin-styles/images/loader.gif")}}" >');
    });
    $(document).ajaxError(function(event, request, settings){
        $('.modal').modal("hide");
        $(this).append("<li>Error requesting page " + settings.url + "</li>");
    });
</script>
@stack('scripts')