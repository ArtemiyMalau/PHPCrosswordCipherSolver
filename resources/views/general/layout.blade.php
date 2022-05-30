<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">

    <meta name="csrf-param" content="_csrf-booster">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<title>@yield("title")</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico"/>

	@routes

	<!-- Bootstrap styles -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<!-- Font Awesome icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
	<script src="https://use.fontawesome.com/4f72667180.js"></script>

	<!-- Project styles -->
    <link rel="stylesheet" type="text/css" href="/css/app.css">
    @stack("css_files")

	<!-- Jquery, Bootstrap scripts -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	
	{{-- EJS template engine --}}
	<script src="/assets/js/ejs/ejs.min.js"></script>

	<!-- Project scripts -->
    <script src="/js/app.js"></script>
	@stack("js_scripts")
</head>
<body>

@include("general.header")

<main role="main">
	<div class="container container-main">
		@yield("main_content")
	</div>
</main>

@include("general.footer")


</body>
</html>