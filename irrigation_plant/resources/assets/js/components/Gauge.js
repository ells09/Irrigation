import gauge from 'canv-gauge';

export default {
  template: '<canvas v-el:gauge_{{gid}} id="gauge_{{ gid }}" ' +
      'data-type="canv-gauge" ' +
      'data-highlights="{{ highlights }}"' +
      'width="150" height="150"></canvas>',

  props: ['gid', 'values', 'highlights', 'min', 'max'],

    events: {
        'Gauge_{{gid}}': function(data) {
            this.$els.setValue(44.0)
        },
    },
        ready() {
  }
}
