 require('./bootstrap');

 window.Vue = require('vue');

import VueLazyload from 'vue-lazyload'
import infiniteScroll from 'vue-infinite-scroll'
import Cookie from 'js-cookie'

Vue.use(VueLazyload)
Vue.use(infiniteScroll)

import store from './store/store.js'
import Filters from './components/Filters'
import Conferences from './components/Conferences'
import Articles from './components/Articles'
import Tutos from './components/Tutos'
import Books from './components/Books'
import Suggestions from './components/Suggestions'
import SearchPage from './components/Search'
import Description from './components/show/Description.vue'
import TutoParts from './components/show/TutoParts.vue'
import ShowSuggestions from './components/show/Suggestions.vue'
import AddForm from './components/create/AddForm.vue'

const app = new Vue({
	el: '#app',
	components: { Filters, Conferences, Articles, Tutos, Books, Suggestions, SearchPage, Description, TutoParts, ShowSuggestions, AddForm },
	data: {
		search: '',
		scrollTop: 0,
		offset: 50,
		toolbarHeight: 56,
		headerContainer: null,
		headerRow: null
	},
	computed: {
		isBusy () {
			return this.$store.getters['common/loadingNextPage']
		}
	},
	watch: {
		search () {
			this.autocomplete()
		}
	},
	store,
	computed: {
		isOpen () {
			return this.$store.getters['filters/isOpen']
		},
		suggestions () {
			return this.$store.getters['filters/suggestions']
		}
	},
	created () {
		this.getSavedSelectedCategories()
	},
	mounted () {
		this.headerContainer = document.querySelector(".mdl-layout__header")
		this.headerRow = document.querySelector(".mdl-layout__header-row")		
	},
	methods: {
		openFilters () {
			this.$store.dispatch('filters/isOpen', true)
		},
		selectTab (tab) {
			this.$store.dispatch('common/setActiveTab', tab)
		},
		autocomplete: _.debounce(function(e) {
				if(this.search.length == 0) return
				this.$store.dispatch('filters/autocomplete', this.search).then( () => {
					if(this.suggestions.length > 0){
						const container = document.querySelector('.container__suggestions')
						container.style.display = 'block'
					}
				}).catch( error => {
					console.log(error)
				})
			}, 500),
		launchSearch() {
			// this.$store.dispatch("common/setSearchTerm", this.search)
			if(this.search.length > 0){
				document.location.href="/search?q="+this.search
			}
		},
		clearSearch () {
			const searchContainer = document.querySelector('#searchField')
			searchContainer.classList.remove('is-focused')
			searchContainer.classList.remove('is-dirty')
			this.$store.dispatch('filters/resetSuggestions')
			this.search = ''
		},
		toggleNavBar(e){

			// const drawerButton = document.querySelector(".mdl-layout__drawer-button")

			//Only if small screen
			if(!this.isSmallScreen()) return

			if(e.target.scrollTop - this.scrollTop > 0) {
				this.headerContainer.classList.add('move-up')
				this.headerContainer.style.maxHeight = "48px"
				// drawerButton.classList.add('fade')
			}else{
				this.headerContainer.classList.remove('move-up')
				this.headerContainer.style.maxHeight = "inherit"
				// drawerButton.classList.remove('fade')
			}

			this.scrollTop = e.target.scrollTop
			
		},
		isSmallScreen () {
			return this.$refs['mdl-layout'].classList.contains('is-small-screen')
		},
		back () {
			window.location.href = '/'
		},
		getSavedSelectedCategories(){
			try {      
				let categoriesFromCookie = Cookie.getJSON('pref_categories')
				if(categoriesFromCookie !== undefined && categoriesFromCookie !== ''){
				  this.$store.dispatch('filters/fetchFromCookie', categoriesFromCookie.selectedCategories)
				}
			  }catch (e) {
				//Do nothing
			  }
		}
	}
});

if ('serviceWorker' in navigator && 'PushManager' in window) {
    window.addEventListener('load', function() {
        navigator.serviceWorker.register('/sw.js').then(function(registration) {
            // Registration was successful
            console.log('ServiceWorker registration successful with scope: ', registration.scope);
        }, function(err) {
            // registration failed :(
            console.log('ServiceWorker registration failed: ', err);
        });
    });
}