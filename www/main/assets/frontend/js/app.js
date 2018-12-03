require('./bootstrap.js');

/* --------- */
import VueBus from 'vue-bus';

/* --------- */
Vue.use(VueBus);

/* --------- */
Vue.component('articles-top-visited', require('./components/articles-top-visited'));

/* --------- */
const app = new Vue({
    el: '#app',
});