<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <title>Irregation plant</title>

    <!-- Latest compiled and minified CSS -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body>
<h1 class="text-center">Betvattningshjälpen</h1>
<div class="container">
    <div class="row">
        @foreach($reports as $report)
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">{{ $report->title }}</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp"> {{ $report->max }} </span>{{ $report->unit }} </div>
                <div class="pull-left">Min: <span class="min-temp"> {{ $report->min }} </span>{{ $report->unit }} </div>
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
