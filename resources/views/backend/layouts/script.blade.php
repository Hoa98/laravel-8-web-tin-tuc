<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{asset('adminlte/dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
{{-- <script src="{{asset('adminlte/plugins/chart.js/Chart.min.js')}}"></script> --}}
<script src="{{asset('adminlte/dist/js/demo.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous"></script>
<script src="{{asset('adminlte/plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>

{{-- <script src="{{asset('adminlte/dist/js/pages/dashboard3.js')}}"></script> --}}
<script>
    $(window).on('load', function(event) {
	$('body').removeClass('preloading');
	$('.loader').delay(1000).fadeOut('fast');
});
</script>