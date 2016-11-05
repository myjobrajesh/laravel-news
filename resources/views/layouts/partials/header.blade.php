<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'News')</title>
	@if(env('APP_ENV')=='production')
	<META NAME="ROBOTS" CONTENT="INDEX, FOLLOW">
	<meta name="description" content="@yield('metaDescription', 'News')" />
    <meta name="keywords" content="News" />
	@else
	<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
	@endif
	<link rel="icon" href="/event.ico" >
    {{--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    --}}
    <link  rel = "stylesheet" href="{{asset('/css/bootstrap.min.css')}}">
    <script src="{{asset('/js/jquery.min.js')}}"></script>
    <script src="{{asset('/js/bootstrap.min.js')}}"></script>
    {{--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" ></script>
    --}}
    <link  rel = "stylesheet" href="{{asset('/css/app.css')}}">
    <link  rel = "stylesheet" href="{{asset('/css/custom.css')}}">
    
	<script type="text/javascript">
        var routeUrl = "{{ url('/') }}";
     </script>
    <script src="{{asset('/js/general.js')}}"></script>
	
	@yield('jsSection')
</head>
	<body class="bodyBg" >
    <section class="headerRow">
        <div class="col-sm-12 col-md-12 col-xs-12"><h1><a href="/">Welcome To News</a></h1></div>
    </section>