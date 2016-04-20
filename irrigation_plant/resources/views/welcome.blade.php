<!DOCTYPE html>
<html>
<head>
    <title>Irregation plant</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="icon"
          type="image/png"
          href="{{ asset('33738-200.png') }}">
</head>
<body>
<div class="container">
    <div class="row">
        <gauge-panel
                title="Temperatur 1"
                :id="1"
                :min="10"
                :max="30"
                highlights="0 10 #0033ff, 10 30 #00ff33, 30 40 #ff3300"
                units="℃"
                majorticks="0 20 40"
                minvalue="0"
                maxvalue="40"
                value="32"
        ></gauge-panel>
        <gauge-panel
                title="Temperatur 2"
                :id="2"
                :min="10"
                :max="30"
                highlights="0 10 #0033ff, 10 30 #00ff33, 30 40 #ff3300"
                units="℃"
                majorticks="0 20 40"
                minvalue="0"
                maxvalue="40"
                value="32"
        ></gauge-panel>
        <gauge-panel
                title="Luftfuktighet"
                :id="3"
                :min="10"
                :max="30"
                highlights="0 30 #0033ff, 30 70 #00ff33, 70 100 #ff3300"
                units="%"
                majorticks="0 50 100"
                minvalue="0"
                maxvalue="100"
                value="44"
        ></gauge-panel>
        <gauge-panel
                title="Jordfuktighet"
                :id="4"
                :min="10"
                :max="30"
                highlights="0 30 #0033ff, 30 70 #00ff33, 70 100 #ff3300"
                units="%"
                majorticks="0 50 100"
                minvalue="0"
                maxvalue="100"
                value="44"
        ></gauge-panel>

        <div class="graph">
            <graph :labels="{{ $labels }}"
                    :values="{{ $values }}"></graph>
            <span>@{{{ legend }}}</span>
        </div>
    </div>
</div>
<script src="/js/main.js"></script>
</body>
</html>
