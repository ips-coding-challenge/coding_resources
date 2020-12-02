<template>
	<div class="container__items">
		<div class="container__books" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="busy" 
			infinite-scroll-distance="150"
		>
			<loader v-show="isLoading"></loader>
			<!-- books -->
			<div class="mdl-grid" v-if="typeError === null">
				<book-item :book="book" v-for="book in data" :key="book.id"></book-item> 
			</div>

			<loader v-show="busy && !hasError"></loader>

			<!-- Empty / Error layout -->
			<empty-error-layout :type="typeError" v-if="typeError !== null" v-on:retryClicked="fetchData('books/fetchData', {page:1, withFilters: false})">		
			</empty-error-layout>
		</div>
	</div>

</template>

<script>


import BookItem from './BookItem'
import EmptyErrorLayout from './EmptyErrorLayout'
import Loader from './Loader'
import itemMixin from '../mixins/item_mixin.js'
import { mapGetters } from 'vuex'

export default {
	name: 'books',
	components: { BookItem, Loader, EmptyErrorLayout },
	props: ['namespace', 'tab'],
	mixins: [itemMixin],	
	watch: {
		searchLaunched () {
			if(this.searchLaunched){
				const activeTab = document.querySelector(this.tab)
				if(activeTab.classList.contains('is-active')){
					this.fetchData(this.namespace +'/fetchData', {page:1, withFilters: true})
				}
			}
		},
		activeTab () {
			if(this.activeTab === 'books' && this.data.length === 0){
				this.fetchData(this.namespace + '/fetchData', {page: 1, withFilters: false})
			}
		}		
	}
	
}
</script>

<style scoped>

</style>