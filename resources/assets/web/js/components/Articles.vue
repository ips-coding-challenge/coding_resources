<template>
	<div class="container__items">
		<div class="container__articles" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="busy" 
			infinite-scroll-distance="150"
		>
			<loader v-show="isLoading"></loader>
			<!-- Conferences -->
			<div class="mdl-grid" v-if="typeError === null">
				<article-item v-for="article in data" :article="article" :key="article.id"></article-item>
			</div>

			<loader v-show="busy && !hasError"></loader>

			<!-- Empty / Error layout -->
			<empty-error-layout :type="typeError" v-if="typeError !== null" v-on:retryClicked="fetchData('articles/fetchData', {page:1, withFilters: false})">
				
			</empty-error-layout>

		</div>
	</div>
</template>

<script>


import ArticleItem from './ArticleItem'
import EmptyErrorLayout from './EmptyErrorLayout'
import Loader from './Loader'
import itemMixin from '../mixins/item_mixin.js'
import { mapGetters } from 'vuex'

export default {
	name: 'articles',
	components: { ArticleItem, Loader, EmptyErrorLayout },
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
			if(this.activeTab === 'articles' && this.data.length === 0){
				this.fetchData(this.namespace + '/fetchData', {page: 1, withFilters: false})
			}
		}
	}
	
}
</script>

<style scoped>

</style>