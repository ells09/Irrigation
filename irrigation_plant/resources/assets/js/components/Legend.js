/**
 * Created by inkre1 on 2016-04-01.
 */
export default {
    template: '<span>{{ GraphLegend }}</span>',

    data: function () {
        return {
            GraphLegend: 'a',
        }
    },

    events: {
        'Graph_legend': function (data) {
            this.GraphLegend = data;
            }
        }
    }
