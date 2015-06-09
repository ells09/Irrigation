/**
 * Created by inkre1 on 15-05-05.
 */

$(function() {
    setInterval(function(){
        $.getJSON('/update/hour', function (dataTableJson) {
            $.each(dataTableJson, function (index, value) {
                lava.loadData(index, value.data, function (chart) {
                    $('.'+index).find('.min-temp').text(value.min);
                    $('.'+index).find('.max-temp').text(value.max);
                });
            });
        });
    }, 60000);
    $( ".show-type" ).change(function() {
        var selectedDiagramType = $('input[name=diagramType]:checked', '#selectDiagram').val()
        $.get('/changeType/' + selectedDiagramType, function (response){
            var data = response;
        });
    });
});
