<!DOCTYPE html>
<html lang="sp" dir="ltr" mode="light">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Valhalla - Admin Dashboard</title>
    <link rel="icon" type="image/png"   href="public/images/favicon.ico">
    
    <!-- Styles <link rel="icon" href="{{ asset('favicon.ico') }}">-->
    {{--<link rel="stylesheet" href="{{ asset(mix('css/main.css')) }}">--}}
    <link rel="stylesheet" href="{{ asset('css/admin/appPageResp.css') }}" />
</head>
<body>
    <noscript>
        <strong>
            We're sorry but {{ env('APP_DESCRIPTION') }} doesn't work properly without JavaScript enabled.
            Please enable it to continue.
        </strong>
    </noscript>
    <div id="app">

    </div>

    <script src="{{ asset('js/admin/app.js') }}"></script>
</body>
</html>
