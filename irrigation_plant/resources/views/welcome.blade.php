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
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Givare 1</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp"> {{ $reports->maxTemp }} </span>&#x2103; </div>
                <div class="pull-left">Min: <span class="min-temp"> {{ $reports->minTemp }} </span>&#x2103; </div>
                <div class="gauge">
                    <div id="temp1_div"></div>
                    @gaugechart('Temp1', 'temp1_div')
                </div>
            </div>

        </div>
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Givare 2</h3>
            <div class="panel-body">
                <div class="pull-right">Max: <span class="max-temp2"> {{ $reports->maxTemp2 }} </span>&#x2103; </div>
                <div class="pull-left">Min: <span class="min-temp2"> {{ $reports->minTemp2 }} </span>&#x2103; </div>
                <div class="gauge">
                    <div id="temp2_div"></div>
                    @gaugechart('Temp2', 'temp2_div')
                </div>
            </div>
        </div>
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Luftfuktighet</h3>
            <div class="panel-body">
                <div class="pull-right ">Max: <span class="max-humidity"> {{ $reports->maxHumi }} </span>%</div>
                <div class="pull-left ">Min: <span class="min-humidity"> {{ $reports->minHumi }} </span>%</div>
                <div class="gauge">
                    <div id="humi_div"></div>
                    @gaugechart('Humi', 'humi_div')
                </div>
            </div>
        </div>
        <div class="col-md-3 panel panel-default">
            <h3 class="panel-heading text-center">Jordfuktighet</h3>
            <div class="panel-body">
                <div class="pull-right ">Max: <span class="max-hygro"> {{ $reports->maxHygro }} </span>% </div>
                <div class="pull-left ">Min: <span class="min-hygro"> {{ $reports->minHygro }} </span>% </div>
                <div class="gauge">
                    <div id="hygro_div"></div>
                    @gaugechart('Hygro', 'hygro_div')
                </div>
            </div>
        </div>
    </div>
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

    <div id="temps_div"></div>
    @linechart('Temps', 'temps_div')
</div>

<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/assets/irregation.js"></script>
</body>
</html>
