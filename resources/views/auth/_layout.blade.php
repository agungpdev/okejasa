<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>{{$title}}</title>
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('assets/favicon_io/apple-touch-icon.png')}}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{asset('assets/favicon_io/android-chrome-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('assets/favicon_io/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('assets/favicon_io/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('assets/favicon_io/site.webmanifest')}}">
    <link rel="mask-icon" href="{{asset('assets/favicon_io/safari-pinned-tab.svg')}}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-TileImage" content="{{asset('assets/favicon_io/mstile-150x150.png')}}">
    <meta name="theme-color" content="#ffffff">
    <!-- CSS files -->
    <link href="{{ asset('assets/be') }}/css/tabler.min.css?1684106062" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            background-image: url("{{asset('assets/bg-auth.jpg')}}");
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            backdrop-filter: blur(3px);
        }
        .form-check-input:checked{
            background-color: #2fb344;
            border-color: rgba(47, 179, 69, 0.14);
        }
        .form-control:focus{
            border-color: #2fb344;
            box-shadow: 0 0 transparent, 0 0 0 0.25rem rgba(47, 179, 69, 0.25);
        }
    </style>
</head>

<body class=" d-flex flex-column">
    @yield('auth')
    <script src="{{ asset('assets/be') }}/js/tabler.min.js?1684106062" defer></script>
</body>

</html>
