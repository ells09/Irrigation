/**
 * Created by inkre1 on 15-05-05.
 */

$(function() {
    //var data;
    // Get the context of the canvas element we want to select
    var ctx = document.getElementById("myChart").getContext("2d");
    var myNewChart = new Chart(ctx).Line(data, {
        responsive : true,
        animation: false,
        //barValueSpacing : 5,
        //barDatasetSpacing : 1,
        tooltipFillColor: "rgba(0,0,0,0.8)",
        multiTooltipTemplate: "<%= datasetLabel %> - <%= value %>",
        scaleShowLabels: true,
        scaleLabel: "<%=value%>"
    });
    $('input:radio[name=diagramType][value=' + data.type + ']').click();
    $('#ex1').slider({
        formatter: function(value) {
            return 'Current value: ' + value;
        }
    });

    setInterval(function(){
        $.getJSON( '/update', function ( response) {
            data = response;
            myNewChart.addData(data.values, data.label);
            myNewChart.removeData();
            myNewChart.update();
            $('.actual-hygro').text(data.values[3] + '%');
            $('.actual-humidity').text(data.values[2] + '%');
            $('.actual-temp1').text(data.values[1] + '℃');
            $('.actual-temp2').text(data.values[0] + '℃');
            if ( $('.min-temp').text() > data.values[0]) {
                $('.min-temp').text(data.values[0]);
            }
            if ( $('.max-temp').text() < data.values[0]) {
                $('.max-temp').text(data.values[0]);
            }
            if ( $('.min-temp2').text() > data.values[1]) {
                $('.min-temp2').text(data.values[1]);
            }
            if ( $('.max-temp2').text() < data.values[1]) {
                $('.max-temp2').text(data.values[1]);
            }
            if ( $('.min-humidity').text() > data.values[2]) {
                $('.min-humidity').text(data.values[2]);
            }
            if ( $('.max-humidity').text() < data.values[2]) {
                $('.max-humidity').text(data.values[2]);
            }
            if ( $('.min-hygro').text() > data.values[3]) {
                $('.min-hygro').text(data.values[3]);
            }
            if ( $('.max-hygro').text() < data.values[3]) {
                $('.max-hygro').text(data.values[3]);
            }
            //$('.type-' + data.type).attr('checked', 'checked');
            $('input:radio[name=diagramType][value=' + data.type + ']').click();
        })
    }, 60000);
    $( ".show-type" ).change(function() {
        var selectedDiagramType = $('input[name=diagramType]:checked', '#selectDiagram').val()
        $.get('/changeType/' + selectedDiagramType, function (response){
            var data = response;
        });
    });
});
