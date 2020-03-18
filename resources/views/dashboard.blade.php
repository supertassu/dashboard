<!doctype html>
<html lang="{{ app()->getLocale() }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
    <link rel="stylesheet" href="https://static.taavi.wtf/fonts/Iosevka/2.3.3/webfont.css">

    <title>
        {{ config('app.name') }}
    </title>

    <script>
        window.baseUrl = '{{ url('/') }}';
        window.openWeatherMapKey = '{{ env('OPENWEATHERMAP_KEY') }}';
        window.pusherKey = '{{ env('PUSHER_APP_KEY') }}';
        window.pusherCluster = '{{ env('PUSHER_APP_CLUSTER') }}';
    </script>
</head>
<body class="bg-black text-white font-mono h-full">

<div class="border-t-8 border-pink-700 p-4 h-full flex flex-col">
    <div class="mt-2 mb-6 w-full">
        <a href="{{ url('/') }}" class="bg-pink-700 p-2 hover:underline">{{ config('app.name') }}</a>
    </div>

    <div class="grid w-full flex-grow" id="app">
        <tile-schedule
            position="a1:a4"
        ></tile-schedule>

        <tile-folding
            position="a5:a8"
        ></tile-folding>

        <tile-embed
            position="b1:e2"
            src="https://grafana.majava.org/d-solo/o17MUrhZz/majava-overview?orgId=1&refresh=1m&theme=dark&panelId=12"
        ></tile-embed>

        <tile-fit-data
            position="b3:b4"
        ></tile-fit-data>

        <tile-time
            position="f1:f2"
            date-format="ddd DD/MM"
            time-zone="Europe/Helsinki"
        ></tile-time>

        <tile-weather
            position="f3:f4"
            city="Helsinki"
        ></tile-weather>
    </div>
</div>

<script src="{{ url(mix('js/app.js')) }}"></script>
</body>
</html>
