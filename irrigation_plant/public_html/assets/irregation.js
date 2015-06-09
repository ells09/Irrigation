/**
 * Created by inkre1 on 15-05-05.
 */

$(function() {
    setInterval(function(){
        $.getJSON('/update', function (dataTableJson) {
            lava.loadData('lineChart', dataTableJson, function (chart) {
                console.log(chart);
            });
        });
    }, 600000);
    $( ".show-type" ).change(function() {
        var selectedDiagramType = $('input[name=diagramType]:checked', '#selectDiagram').val()
        $.get('/changeType/' + selectedDiagramType, function (response){
            var data = response;
        });
    });
});
