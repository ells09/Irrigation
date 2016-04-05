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
        command: 'hour',
    },

  components: { Graph, Gauge, Legend },

    events: {
        'legend': function (msg) {
            // `this` in event callbacks are automatically bound
            // to the instance that registered it
            this.legend = msg
        }
    },

    methods: {
        getDay: function() {
            this.command = 'day'
        },
        getHour: function() {
            this.command = 'hour'
        },
        getLastHour: function () {
            this.command = 'lastHour'
        },
        getLastMinute: function () {
            this.command = 'lastMinute'
        },

        update: function () {
            // GET request
            this.$http.get('/update/' + this.command).then(function (response) {

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

        }
    },

  ready: function() {
      var self = this;

      this.update();
      this.command = 'lastMinute'
      setInterval( function() {
            self.update();

      }, 60000);
  }
})
