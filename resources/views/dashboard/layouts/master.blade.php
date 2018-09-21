<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>CONA &#8211; @yield('title')</title>
    <meta name="description" content="CONA">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="{{ asset('css/dashboard/custom-style.css') }}">
    @yield('styles')

</head>
<body>
    <div class="loader">
        <div class="lds-ellipsis"><div></div><div></div><div></div><div></div></div>
    </div>

    <div class="body-toload" style="display: none;">
        {{-- left Panel --}}
        @include('dashboard.layouts.sidebar')
        {{-- Left Panel --}}

        {{-- Right Panel --}}
        <div id="right-panel" class="right-panel">

            {{-- Header --}} 
            @include('dashboard.layouts.header')
            {{-- Header --}}

            {{-- content --}}
            <div class="content mt-3 pl-4 pr-4">
                @yield('content')
            </div>
            {{-- content --}}
            
        </div>
        {{-- Right Panel --}}
    </div>
    
    {{-- Right Panel --}}
    <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<<<<<<< HEAD
    <script src="{{ asset('js/dashboard/main.js') }}"></script>
    <script src="{{ asset('js/dashboard/custom-script.js') }}"></script>
=======
    <script src="{{asset('/js/dashboard/main.js')}}"></script>
    <script src="{{asset('/js/dashboard/custom-script.js')}}"></script>
>>>>>>> ce822c4c4f7b8fc44376b1063473b6dbb93a2aa4

    @yield('scripts')

</body>
</html>
