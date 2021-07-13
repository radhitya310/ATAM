<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- untuk API Key Google Maps --}}
        <!-- Menyisipkan library Google Maps -->
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCKS2mXUVPMYPSYCvB7RJ0PDfu0EKCHdtI&libraries=places&callback=initAutocomplete"></script>
        {{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVsQd9kuPHlaTw4zziaAKDv24O2T6O31c&callback=initMap"></script> --}}
        {{-- <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDVsQd9kuPHlaTw4zziaAKDv24O2T6O31c&libraries=places&callback=initAutocomplete"></script> --}}
        {{-- <script async defer src="https://maps.google.com/maps/api/js?key=AIzaSyDVsQd9kuPHlaTw4zziaAKDv24O2T6O31c&amp;libraries=places&amp;callback=initAutocomplete"></script> --}}
        {{-- <script src="http://maps.googleapis.com/maps/api/js"></script> --}}

        <!-- Scripts -->
        {{-- <script src="/js/script.js" defer></script>
        <script src="/js/jQuery.js" defer></script>
        <script src="/js/bootstrap.bundle.min.js" defer></script>
        <script src="/js/animationHeader.js" defer></script> --}}
        <script src="{{asset('js/script.js')}}" defer></script>
        <script src="{{asset('js/jQuery.js')}}" defer></script>
        <script src="{{asset('js/bootstrap.bundle.min.js')}}" defer></script>
        <script src="{{asset('js/animationHeader.js')}}" defer></script>

        {{-- <script src="{{ asset('js/script.js') }}" defer></script>
        <script src="{{ asset('js/jQuery.js') }}" defer></script>
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script> --}}
        {{-- dari laravel 5 untuk app.js nya --}}
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        {{-- <script src="{{ asset('js/auto_logout.js') }}" defer></script> --}}
        {{-- <script src="{{ asset('js/bootstrap.min.js') }}" defer></script> --}}

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Fonts -->
        {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

        <!-- font awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> --}}
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.3/css/fontawesome.min.css" integrity="sha384-wESLQ85D6gbsF459vf1CiZ2+rr+CsxRY0RpiF1tLlQpDnAgg6rwdsUF1+Ics2bni" crossorigin="anonymous"> --}}

        <!-- Bootstrap CSS version 4.6-->
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous"> --}}

        <!-- Styles -->
        {{-- <link href="/css/app.css" rel="stylesheet">
        <link href="/css/style.css" rel="stylesheet"> --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">

        <title>@yield('title')</title>
    </head>
    <body>
        {{-- include => untuk mengambil code dari isi file "header.blade.php" --}}
        @include('include.header')

        <div class="isi">
            @yield('content')
        </div>

        @include('include/footer')

        {{-- untuk bootstrap version 4.6 --}}
        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script> --}}
    </body>
</html>
