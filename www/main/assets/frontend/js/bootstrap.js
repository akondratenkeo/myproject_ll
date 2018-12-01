/**
 * Load Lodash & PopperJS.
 */
window._ = require('lodash');
window.Popper = require('popper.js').default;

/**
 * Load Axios.
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// let token = document.head.querySelector('meta[name="csrf-token"]');
//
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }


/**
 * Load Vue.
 */
window.Vue = require('vue');

import 'es6-promise/auto'