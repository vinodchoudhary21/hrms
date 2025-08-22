<script src="{{ url('public/tostar_msg/js/jquery.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ url('public/tostar_msg/css/toastr.min.css') }}">
<script src="{{ url('public/tostar_msg/js/toastr.js') }}"></script>

<script>
@if(Session::has('success'))
toastr.options =
{
 "positionClass": "toast-top-center",
 "closeButton" : true,
 "progressBar" : true,
 "timeOut": 2000,

}
      toastr.success("{{ session('success') }}");
@endif

@if(Session::has('error'))
toastr.options =
{
    "positionClass": "toast-top-center",
 "closeButton" : true,
 "progressBar" : true,
 "timeOut": 2000,

}
      toastr.error("{{ session('error') }}");
@endif

@if(Session::has('info'))
toastr.options =
{
    "positionClass": "toast-top-center",
 "closeButton" : true,
 "progressBar" : true,
 "timeOut": 2000,

}
      toastr.info("{{ session('info') }}");
@endif

@if(Session::has('warning'))
toastr.options =
{
    "positionClass": "toast-top-center",
 "closeButton" : true,
 "progressBar" : true,
 "timeOut": 2000,

}
      toastr.warning("{{ session('warning') }}");
@endif
</script>