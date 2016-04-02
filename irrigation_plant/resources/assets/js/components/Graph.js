import Chart from 'chart.js';

export default {
  template: '<canvas width="1200" height="400" id="graph"></canvas>',

  props: ['labels', 'values'],

  data: function(){
    return {
      GraphData: [19,20,21,1,1,1,1,1,1,1,19,20,21,1,1,1,1,1,1,1,19,20,21,1,1,1,1,1,1,1,19,20,21,1,1,1,1,1,1,1,19,20,21,1,1,1,1,1,1,1,19,20,21,1,1,1,1,1,1,1,],
      chart: '',
    }
  },

  events: {
    'Graph_data': function(data) {
      this.GraphData = data;
      //this.chart.addData('22', "April")
      var i = 0;
      while (i < data['temp1'].length) {
          this.chart.datasets[0].points[i].value = data['temp1'][i];
          this.chart.datasets[1].points[i].value = data['temp2'][i];
          this.chart.datasets[2].points[i].value = data['humidity'][i];
          this.chart.datasets[3].points[i].value = data['hygrometer'][i];
          this.labels[i] = data['labels'][i];
        i++;
        }
      this.chart.update();
    }
  } ,

  ready() {
    var data = {
      labels: this.labels,
      datasets: [
      {
        label: 'Temperatur 1',
        fillColor: "rgba(255,220,220,0.2)",
        strokeColor: "rgba(255,0,0,1)",
        pointColor: "rgba(0,22,0,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighliteStroke: "rgba(255,220,220,1)",
        data: this.GraphData
      },
      {
        label: 'Temperatur 2',
        fillColor: "rgba(220,220,255,0.2)",
        strokeColor: "rgba(0,0,255,1)",
        pointColor: "rgba(0,22,0,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighliteStroke: "rgba(220,220,255,1)",
        data: this.GraphData
      },
        {
          label: 'humidity',
          fillColor: "rgba(255,255,220,0.2)",
          strokeColor: "rgba(255,255,0,1)",
          pointColor: "rgba(0,22,0,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighliteStroke: "rgba(255,255,220,1)",
          data: this.GraphData
        },
        {
          label: 'hygrometer',
          fillColor: "rgba(220,255,220,0.2)",
          strokeColor: "rgba(0,255,0,1)",
          pointColor: "rgba(0,22,0,1)",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fff",
          pointHighliteStroke: "rgba(220,255,220,1)",
          data: this.GraphData
        }
      ]
    }
    var context = document.querySelector('#graph').getContext('2d');

    this.chart = new Chart(context).Line(data, {
      scaleOverride : true,
              scaleSteps : 10,
              scaleStepWidth : 10,
              scaleStartValue : 0

    });
    var legend = this.chart.generateLegend();
    this.$broadcast('Graph_legend', this.chart.generateLegend());

  }
}
