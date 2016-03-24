import Vue from 'vue';
import Graph from './components/Graph';
import Gauge from './components/Gauge';

new Vue({
  el: 'body',

  components: { Graph, Gauge },

  ready() {
    console.log('ready');
    //gauge.Collection.get(1).setValue( 54.3);
  }
})
