import Vue from 'vue';
import VueResource from 'vue-resource';
import Graph from './components/Graph';
import Gauge from './components/Gauge';
import Legend from './components/Legend';

Vue.use(VueResource);

// Initialize HTTP requests
//http.init(Vue)
new Vue({
  el: 'body',

    data: {
        GraphData: '',
        legend: 'hej',
    },

  components: { Graph, Gauge, Legend },

    events: {
        'legend': function (msg) {
            // `this` in event callbacks are automatically bound
            // to the instance that registered it
            this.legend = msg
        }
    },

  ready: function() {
      var self = this;
      setInterval( function() {

          // GET request
          self.$http.get('/update').then(function (response) {

              // get status
              response.status;

              // get all headers
              response.headers();

              // get 'expires' header
              response.headers('expires');

              // set data on vm
              this.$broadcast('Graph_data', response.data)

          }, function (response) {

              // error callback
          });

      }, 60000);
  }
})
