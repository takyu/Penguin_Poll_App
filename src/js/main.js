/**
 * Load vendor's style files
 */

/**
 * Load style files
 */
import '../assets/_sass/style.scss';

/**
 * Load vendor's js files
 */

/**
 * Load js module files
 */
import { nodeOps } from './modules/nodeOps';
import { pollChart } from './modules/pie-chart';
import { validateForm } from './modules/form-validate';
import { toggleDisplayPass } from './modules/toggle-display-pass';

nodeOps.on(document, 'DOMContentLoaded', () => {
  // draw chart
  pollChart();

  // enabled validate form
  validateForm();

  // toggle to display password
  toggleDisplayPass();
});
