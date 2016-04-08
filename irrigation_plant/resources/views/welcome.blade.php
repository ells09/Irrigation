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
        <gauge-panel title="Temperatur 1" :id="1" :min="10" :max="30"></gauge-panel>
        <gauge-panel title="Temperatur 2" :id="2" :min="10" :max="30"></gauge-panel>
        <gauge-panel title="Luftfuktighet" :id="3" :min="10" :max="30"></gauge-panel>
        <gauge-panel title="Jordfuktighet" :id="4" :min="10" :max="30"></gauge-panel>

        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Temperatur 2</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp">33 </span>℃</div>
                <div class="pull-left">Min: <span class="min-temp">13</span>℃</div>
                <div class="gauge">
                    <span>
                        <gauge
                                :gid=2
                                :min=11
                                :max=31
                                highlights="0 10 #0033ff, 10 30 #00ff33, 30 40 #ff3300"
                                data-units="℃"
                                data-major-ticks="0 20 40"
                                data-min-value="0"
                                data-max-value="40"
                                data-value=32
                                data-colors-needle-circle-innerend="#000"
                        ></gauge>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Luftfuktighet</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp">33 </span>℃</div>
                <div class="pull-left">Min: <span class="min-temp">13</span>℃</div>
                <div class="gauge">
                    <span>
                        <gauge :gid=3
                               highlights="0 30 #0033ff, 30 70 #00ff33, 70 100 #ff3300"
                               data-units="%"
                               data-major-ticks="0 50 100"
                               data-min-value="0"
                               data-max-value="100"
                               data-value=66
                        ></gauge>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Jordfuktighet</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp">33 </span>℃</div>
                <div class="pull-left">Min: <span class="min-temp">13</span>℃</div>
                <div class="gauge">
                    <span>
                        <gauge :gid=4
                               highlights="0 30 #0033ff, 30 70 #00ff33, 70 100 #ff3300"
                               data-units="%"
                               data-major-ticks="0 50 100"
                               data-min-value="0"
                               data-max-value="100"
                               data-value=28></gauge>
                    </span>
                </div>
            </div>
        </div>
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
