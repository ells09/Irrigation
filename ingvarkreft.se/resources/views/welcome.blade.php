<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <title>Irregation plant</title>
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <link rel="icon"
          type="image/png"
          href="{{ asset('33738-200.png') }}">
</head>
<body>
<a href="https://github.com/IngWARP"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
<h1 class="text-center">Betvattningshjälpen</h1>
<div class="container">
    <div class="row">
        @foreach($reports as $report)
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">{{ $report->title }}</h3>
            <div class="panel-body">
                <div class="pull-right {{ $report->name }}">Max: <span class="max-temp"> {{ $report->max }} </span>{{ $report->unit }} </div>
                <div class="pull-left {{ $report->name }}">Min: <span class="min-temp"> {{ $report->min }} </span>{{ $report->unit }} </div>
                <div class="gauge">
                    <div id="{{ $report->name }}_div"></div>
                    @gaugechart( $report->name, $report->name . '_div')
                </div>
            </div>

        </div>
        @endforeach
    </div>
    <!--
    <form id="selectDiagram">
        <div class="row">
            <div class="col-sm-2">Visa diagram för </div>
            <div class="col-sm-9">
                <div class="btn-group" data-toggle="buttons">
                    <label class="btn btn-default active">
                        <input class="show-type" type="radio" id="hour" name="diagramType" checked="checked" value="hour" /> Timme
                    </label>
                    <label class="btn btn-default">
                        <input class="show-type" type="radio" id="day" name="diagramType" value="day" /> Dag
                    </label>
                </div>
            </div>
        </div>
    </form>
    -->
    <div id="temps_div"></div>
    @linechart('lineChart', 'temps_div')
</div>

<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/irregation.js"></script>
</body>
</html>
