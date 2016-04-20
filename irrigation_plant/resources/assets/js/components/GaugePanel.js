/**
 * Created by inkre1 on 2016-04-08.
 */

import Gauge from './Gauge'

export default {
    components: {Gauge},

    props: ['title', 'id', 'min', 'max', 'highlights', 'units', 'majorticks', 'minvalue', 'maxvalue', 'value'],

    data: function(){
        return {
            nvalue: this.value,
        }
    },

    template: '<div class="col-md-3 panel panel-default">' +
    '<h3 class="panel-heading text-center">{{ title }}</h3>' +
    '<div class="panel-body">' +
    '<div class="pull-right">Max: <span class="max-temp">{{ max }} </span>℃</div>' +
    '<div class="pull-left">Min: <span class="min-temp">{{ min }}</span>℃</div>' +
    '<div class="gauge"><span><gauge :gid=id :highlights="highlights" data-units="{{units}}" data-major-ticks="{{majorticks}}" data-min-value="{{minvalue}}" data-max-value="{{maxvalue}}" data-value={{nvalue}}></gauge></span> </div>' +
    '</div>' +
    '</div>'

}