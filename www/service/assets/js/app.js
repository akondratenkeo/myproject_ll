require('./bootstrap.js');

/* --------- */
import VueBus from 'vue-bus';

/* --------- */
Vue.use(VueBus);

/* --------- */
const app = new Vue({
    el: '#app',
});
