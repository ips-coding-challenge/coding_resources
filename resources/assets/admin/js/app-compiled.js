
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import LinkInputForYoutube from './components/LinkInputForYoutube.vue';
// import TutoPartsForm from './components/TutoPartsForm.vue'
import TutoForm from './components/tuto/Form.vue';
// Vue.component('quick-add', require('./components/LinkInputForYoutube.vue'));

const app = new Vue({
  el: '#app',
  components: { LinkInputForYoutube, TutoForm }
});

//# sourceMappingURL=app-compiled.js.map