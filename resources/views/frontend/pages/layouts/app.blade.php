<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="author" content="INSPIRO"/>
    <meta name="description" content="RVParkHQ">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RVParkHQ</title>
    <link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body>

<div class="body-inner">
    @if(session('success'))
        <script>
            Swal.fire({
                text: '{{ session('success') }}',
                icon: '{{ session('icon') }}',
                position: 'top-end',
                timer: 4000,
                showConfirmButton: false,
                timerProgressBar: true,
            });
        </script>
    @endif
    @include('frontend.pages.layouts.partials.header')
    @yield('content')
    @include('frontend.pages.layouts.partials.footer')
</div>

<a id="scrollTop"><i class="icon-chevron-up"></i><i class="icon-chevron-up"></i></a>

<script src="{{ asset('assets/js/jquery.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>
<script src="{{ asset('assets/js/functions.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/gmap3/gmap3.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/gmap3/map-styles.js') }}"></script>
</body>

</html>
