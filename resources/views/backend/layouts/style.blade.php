<!-- Font Awesome Icons -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">
<!-- IonIcons -->
<link rel="stylesheet" href="{{asset('adminlte/plugins/ionicons.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('adminlte/dist/css/adminlte.min.css')}}">
<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" integrity="sha512-vKMx8UnXk60zUwyUnUPM3HbQo8QfmNx7+ltw8Pm5zLusl1XIfwcxo8DbWCqMGKaWeNxWA8yrx5v3SaVpMvR3CA==" crossorigin="anonymous" />
<link rel="stylesheet" href="{{asset('adminlte/plugins/sweetalert2/sweetalert2.min.css')}}">
<style>
    .loader{
	width: 100%;
	height: 100%;
	background: #9c9d9e52;
	position: fixed;
	top: 0;
	left: 0;
	z-index: 100000000000;
	display: block;
	overflow: hidden;
}
.iconload{
	font-size: 80px;
	color: #fff;
	position: absolute; 
	top: 50%;
	left: 50%;
	margin-top: -40px;
	margin-left: -40px;
}
.xoay{
	animation: xoay 1.5s linear infinite;
	-moz-animation: xoay 1.5s linear infinite;
	-ms-animation: xoay 1.5s linear infinite;
	-o-animation: xoay 1.5s linear infinite;
	-webkit-animation: xoay 1.5s linear infinite;
}
@-webkit-keyframes xoay{
	from{
		-ms-transform:rotate(0deg);
		-moz-transform: rotate(0deg);
		-o-transform: rotate(0deg);
		-webkit-transform: rotate(0deg);
		transform: rotate(0deg);
	}
	to{
		-ms-transform:rotate(360deg);
		-moz-transform: rotate(360deg);
		-o-transform: rotate(360deg);
		-webkit-transform: rotate(360deg);
		transform: rotate(360deg);
	}
}
</style>
