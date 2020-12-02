<template>
	<div class="container__items">
		<div class="container__articles" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="busy" 
			infinite-scroll-distance="150"
		>
			<loader v-show="isLoading"></loader>
			<!-- Items -->
			<div class="mdl-grid">
				<search-item :item-type="item.type" :item="item" v-for="item in data" :key="item.id"></search-item>
			</div>

			<loader v-show="busy"></loader>

			<!-- Empty / Error layout -->
		<!-- 	<empty-error-layout :type="typeError" v-if="typeError !== null" v-on:retryClicked="fetchData('search/fetchData', {page:1, withFilters: false})">				
			</empty-error-layout> -->

		</div>
	</div>
</template>

<script>

import SearchItem from './SearchItem'
import EmptyErrorLayout from './EmptyErrorLayout'
import Loader from './Loader'
import itemMixin from '../mixins/item_mixin.js'
import { mapGetters } from 'vuex'
import queryString from 'query-string'

export default {
	name: 'search-page',
	components: { SearchItem, Loader, EmptyErrorLayout },
	props: ['namespace'],
	mixins: [itemMixin],
	data () {
		return {
			searchTerm: ''
		}
	},
	watch: {
		searchLaunched () {
			if(this.searchLaunched){
				this.fetchData(this.namespace +'/fetchData', {page:1, q: this.searchTerm})
			}
		}
	},
	mounted () {
		this.searchTerm = queryString.parse(location.search).q
		console.log(this.searchTerm)
		this.searchData(this.namespace+'/fetchData', {page: 1, q: this.searchTerm})
	},
	methods: {
		searchData (action, params) {

			this.isLoading = true

			this.$store.dispatch(this.namespace + '/setError', false)
			this.$store.dispatch(this.namespace + '/isEmpty', false)

			this.$store.dispatch(action, {
				page: params.page,
				q: params.q
			}).then( () => {
				this.isLoading = false	
				this.busy = false
				this.$store.dispatch('filters/searchLaunched', false)			
			}).catch(error => {
				console.log(error)
				this.isLoading = false
				this.$store.dispatch(this.namespace + '/setError', true)
				//To avoid fetching next page if an error occurred
				this.busy = true
			})
		},
		loadMore() {
	
			if(this.currentPage + 1 > this.lastPage) {
				return
			}

			this.busy = true
			this.searchData(this.namespace + '/fetchData', {page: this.currentPage + 1, q: this.searchTerm})
			
		},
	}
	
}
</script>

<style scoped>

</style>