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

    @auth
        <script>
            window.baseUrl = '{{ url('/') }}';
            window.openWeatherMapKey = '{{ env('OPENWEATHERMAP_KEY') }}';
            window.pusherKey = '{{ env('PUSHER_APP_KEY') }}';
            window.pusherCluster = '{{ env('PUSHER_APP_CLUSTER') }}';
        </script>
    @endauth
</head>
<body class="bg-black text-white font-mono h-full">

<div class="border-t-8 border-pink-700 p-4 h-full flex flex-col">
    <div class="mt-2 mb-6 w-full">
        <div class="flex justify-between">
            <a href="{{ url('/') }}" class="bg-pink-700 p-2 hover:underline">{{ config('app.name') }}</a>

            <div>
                @auth
                    Logged in as {{ Auth::user()->name }}.
                    <form method="post" action="{{ route('logout') }}" class="inline-block">
                        @csrf
                        <button class="underline hover:no-underline">Logout?</button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    @yield('content')
</div>

<script src="{{ url(mix('js/app.js')) }}"></script>
</body>
</html>
