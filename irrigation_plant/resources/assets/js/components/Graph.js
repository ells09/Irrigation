import Chart from 'chart.js';

export default {
  template: '<canvas width="1200" height="400" id="graph"></canvas>',

  props: ['labels', 'values'],

  data: function(){
    return {
      GraphData: [11,],
      chart: '',
      legend: '',
    }
  },

  events: {
    'Graph_data': function(data) {
      var self = this;
      this.GraphData = data;
      while (this.chart.datasets[0].points.length) {
        this.chart.removeData();
      }

      this.GraphData.data.forEach (function(points, label) {
        self.chart.addData(points[0], points[1])
      });
    }
  },

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
    this.legend = this.chart.generateLegend();
    this.$dispatch('legend', this.legend);

  }
}
