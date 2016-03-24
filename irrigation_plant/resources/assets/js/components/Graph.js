import Chart from 'chart.js';

export default {
  template: '<canvas width="600" height="400" id="graph"></canvas>',

  props: ['labels', 'values'],

  ready() {
    var data = {
      labels: this.labels,
      datasets: [
      {
        fillColor: "rgba(220,220,220,0.2)",
        strokeColor: "rgba(220,220,220,1)",
        pointColor: "rgba(220,220,220,1)",
        pointStrokeColor: "#fff",
        pointHighlightFill: "#fff",
        pointHighliteStroke: "rgba(220,220,220,1)",
        data: this.values
      }
      ]
    }
    var context = document.querySelector('#graph').getContext('2d');

    new Chart(context).Line(data);
  }
}
