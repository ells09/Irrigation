import gauge from 'canv-gauge';

export default {
  template: '<canvas id="{{ gid }}" data-type="canv-gauge" width="200" height="200"></canvas>',

  props: ['gid', 'values'],

  ready() {
  //  var data = {
  //    labels: this.labels,
  //    datasets: [
  //    {
  //      fillColor: "rgba(220,220,220,0.2)",
  //      strokeColor: "rgba(220,220,220,1)",
  //      pointColor: "rgba(220,220,220,1)",
  //      pointStrokeColor: "#fff",
  //      pointHighlightFill: "#fff",
  //      pointHighliteStroke: "rgba(220,220,220,1)",
  //      data: this.values
  //    }
  //    ]
  //  }

  //  new Chart(
  //    this.$el.getContext('2d')
   //   ).context).Line(data);
  }
}
