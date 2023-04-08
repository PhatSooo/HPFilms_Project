<!DOCTYPE html>
<html lang="en" class="no-js">

<head>
	<!-- Basic need -->
	<title>@yield('title')</title>
	<meta charset="UTF-8">
	<meta name="description" content="">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<link rel="profile" href="#">

    <!--Google Font-->
    <link rel="stylesheet" href='http://fonts.googleapis.com/css?family=Dosis:400,700,500|Nunito:300,400,600' />
	<!-- Mobile specific meta -->
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone-no">

	<!-- CSS files -->
	<link rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
	<link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>

@if (Session::has('login_fail'))
    <script>
        alert('Login Failed');
    </script>
@endif

<body>
<!--preloading-->
@include('layouts.partials.preloading')
<!--end of preloading-->

<!--login & signup form popup-->
@include('layouts.partials.popup')
<!--end of login & signup form popup-->

<!-- BEGIN | Header -->
@include('layouts.partials.header')
<!-- END | Header -->

@yield('contents')

<!-- footer section-->
@include('layouts.partials.footer')
<!-- end of footer section-->

<script src="{{asset('assets/js/jquery.js')}}"></script>
<script src="{{asset('assets/js/plugins.js')}}"></script>
<script src="{{asset('assets/js/plugins2.js')}}"></script>
<script src="{{asset('assets/js/custom.js')}}"></script>

</body>
</html>
