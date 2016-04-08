import gauge from 'canv-gauge';

export default {
  template: '<canvas id="gauge_{{ gid }}" ' +
      'data-type="canv-gauge" ' +
      'data-highlights="{{ highlights }}"' +
      'width="150" height="150"></canvas>',

  props: ['gid', 'values', 'highlights', 'min', 'max'],

  ready() {
  }
}
