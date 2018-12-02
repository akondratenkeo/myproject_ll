require('./bootstrap.js');

/* --------- */
import VueBus from 'vue-bus';

/* --------- */
Vue.use(VueBus);

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

Echo.channel('test')
    .listen('.zzz', () => {
        console.log('wwwwwww');
    });