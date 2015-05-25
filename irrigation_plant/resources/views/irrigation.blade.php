<!DOCTYPE html>
<html lang="sv-SE">
<head>
    <title>Irregation plant</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
</head>
<body>
<h1 class="text-center">Betvattningshjälpen</h1>
    <div class="container">
        <div class="row">
            <div class="col-md-3 panel panel-default">
                <h3 class="panel-heading text-center">Växthuset</h3>
                <div class="panel-body">
                    <div class="pull-right">Max: <span class="max-temp"> {{ $measurement_data->maxTemp }} </span>&#x2103; </div>
                    <div class="pull-left">Min: <span class="min-temp"> {{ $measurement_data->minTemp }} </span>&#x2103; </div>
                    <h2 class="text-center actual-temp1"> {{ $measurement_data->actual[0]->temperature }}&#x2103; </h2>
                </div>
            </div>
            <div class="col-md-3 panel panel-default">
                <h3 class="panel-heading text-center">Övervintringstältet</h3>
                <div class="panel-body">
                    <div class="pull-right">Max: <span class="max-temp2"> {{ $measurement_data->maxTemp2 }} </span>&#x2103; </div>
                    <div class="pull-left">Min: <span class="min-temp2"> {{ $measurement_data->minTemp2 }} </span>&#x2103; </div>
                    <h2 class="text-center actual-temp2"> {{ $measurement_data->actual[0]->temperature2 }}&#x2103; </h2>
                </div>
            </div>
            <div class="col-md-3 panel panel-default">
                <h3 class="panel-heading text-center">Luftfuktighet</h3>
                <div class="panel-body">
                    <div class="pull-right ">Max: <span class="max-humidity"> {{ $measurement_data->maxHumi }} </span>%</div>
                    <div class="pull-left ">Min: <span class="min-humidity"> {{ $measurement_data->minHumi }} </span>%</div>
                    <h2 class="text-center actual-humidity"> {{ $measurement_data->actual[0]->humidity }}%</h2>
                </div>
            </div>
            <div class="col-md-3 panel panel-default">
                <h3 class="panel-heading text-center">Jordfuktighet</h3>
                <div class="panel-body">
                    <div class="pull-right ">Max: <span class="max-hygro"> {{ $measurement_data->maxHygro }} </span>% </div>
                    <div class="pull-left ">Min: <span class="min-hygro"> {{ $measurement_data->minHygro }} </span>% </div>
                    <h2 class="text-center actual-hygro"> {{ $measurement_data->actual[0]->hygrometer }}% </h2>
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

        <div >
            <canvas id="myChart" width="1000" height="400">

            </canvas>
        </div>
    </div>

        <!-- Latest compiled and minified JavaScript -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https:////cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
    <script type="text/javascript" src="/assets/irregation.js"></script>
    <script type="text/javascript">
        var data = <?php echo $measurement_data->json; ?>;
    </script>
</body>
</html>