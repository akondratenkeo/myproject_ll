require('./bootstrap.js');

/* --------- */
import VueBus from 'vue-bus';

/* --------- */
Vue.use(VueBus);

/* --------- */
Vue.component('action-form', require('./components/action-form'));

/* --------- */
const app = new Vue({
    el: '#app',

    mounted() {
        console.log('Vue application booted...');
    },

    data() {
        return {
            //
        };
    }
});
