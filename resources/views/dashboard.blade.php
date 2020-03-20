@extends('layout')
@section('content')
    <div class="grid w-full flex-grow" id="app">
        <tile-schedule
            position="a1:a4"
        ></tile-schedule>

        <tile-folding
            position="a5:a8"
        ></tile-folding>

        <tile-embed
            position="b1:e2"
            src="https://grafana.majava.org/d-solo/o17MUrhZz/majava-overview?orgId=1&refresh=1m&theme=dark&panelId=8"
        ></tile-embed>

        <tile-embed
            position="b3:e4"
            src="https://grafana.majava.org/d-solo/o17MUrhZz/majava-overview?orgId=1&refresh=1m&theme=dark&panelId=12"
        ></tile-embed>

        <tile-time
            position="f1:f2"
            date-format="ddd DD/MM"
            time-zone="Europe/Helsinki"
        ></tile-time>

        <tile-weather
            position="f3:f4"
            city="Helsinki"
        ></tile-weather>

        <tile-fit-data
            position="f5:f6"
        ></tile-fit-data>
    </div>
@endsection
