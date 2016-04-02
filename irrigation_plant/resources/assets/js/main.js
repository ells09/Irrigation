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
    },

  components: { Graph, Gauge, Legend },

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
              this.$set('GraphData', response.data)
             // self.Graph_data;
              this.$broadcast('Graph_data', response.data)

          }, function (response) {

              // error callback
          });

      }, 600000);
  }
})
