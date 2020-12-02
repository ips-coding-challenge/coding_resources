
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
import LinkInputForYoutube from './components/LinkInputForYoutube.vue'

import TutoForm from './components/tuto/Form.vue'
import EditInput from './components/category/EditInput.vue'
import CategoryModal from './components/category/CategoryModal.vue'
import TitleInput from './components/proposition/TitleInput.vue'
import QuickAddBook from './components/book/QuickAddBook.vue'
import YoutubeIssues from './components/issues/YoutubeIssues.vue'
import CategoriesInput from './components/category/CategoriesInput.vue';
// import VueSelect from 'vue-select';


// Vue.component('v-select', VueSelect);

const app = new Vue({
	el: '#app',
	components: { CategoriesInput, LinkInputForYoutube, TutoForm, EditInput, CategoryModal, TitleInput, QuickAddBook, YoutubeIssues },
	mounted() {
		this.fetchCategories()
		this.preventEnter()
	},
	methods: {
		fetchCategories() {

			//TODO NEED TO CHANGE TO ONLY FETCH CATEGORIES ON EDIT PAGES
			// if ($("#categories").length == 0) return false

			// axios.get('/api/categories').then(response => {

			// 	const newList = [];
			// 	response.data.data.forEach(function (item) {
			// 		newList.push(item.name)
			// 	});
			// 	awesomplete(newList)

			// })
		},
		preventEnter() {
			// TODO NEED TO CHANGE TO ALLOW ENTER PRESS FOR SEARCH
			$(window).keydown(function (event) {
				if (event.keyCode == 13) {
					event.preventDefault();
					return false;
				}
			});
		}
	}
});

// const awesomplete = function (list) {

// 	return new Awesomplete(document.querySelector('#categories'), {
// 		list: list,
// 		filter: function (text, input) {
// 			return Awesomplete.FILTER_CONTAINS(text, input.match(/[^,]*$/)[0]);
// 		},

// 		item: function (text, input) {
// 			return Awesomplete.ITEM(text, input.match(/[^,]*$/)[0]);
// 		},

// 		replace: function (text) {
// 			var before = this.input.value.match(/^.+,\s*|/)[0];
// 			this.input.value = before + text + ",";
// 		}
// 	});
// }
