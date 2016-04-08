/**
 * Created by inkre1 on 2016-04-08.
 */

import Gauge from './Gauge'

export default {
    components: {Gauge},

    props: ['title', 'id', 'min', 'max'],

    template: '<div class="col-md-3 panel panel-default">' +
                    '<h3 class="panel-heading text-center">{{ title }}</h3>'+
                    '<div class="panel-body">'+
                        '<div class="pull-right">Max: <span class="max-temp">{{ max }} </span>℃</div>'+
                        '<div class="pull-left">Min: <span class="min-temp">{{ min }}</span>℃</div>'+
                        '<div class="gauge">'+
                            '<span>'+
                            '<gauge'+
                                ' :gid={{ id }}'+
                                ' highlights="0 10 #0033ff, 10 30 #00ff33, 30 40 #ff3300"'+
                                ' data-units="℃"'+
                                ' data-major-ticks="0 20 40"'+
                                ' data-min-value="0"'+
                                ' data-max-value="40"'+
                                ' data-value=22'+
                        '></gauge>'+
                            '</span>'+
                        '</div>'+
                    '</div>'+
        '</div>'

}