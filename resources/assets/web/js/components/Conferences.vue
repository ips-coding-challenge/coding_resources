<template>
	<div class="container__items">
		<div class="container__conferences" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="busy" 
			infinite-scroll-distance="150"
		>
			<loader v-show="isLoading"></loader>
			<!-- Conferences -->
			<div class="mdl-grid" v-if="typeError === null">
				<video-item type="conference" :item="conf" v-for="conf in data" :key="conf.id"></video-item> 
			</div>

			<loader v-show="busy && !hasError"></loader>

			<!-- Empty / Error layout -->
			<empty-error-layout :type="typeError" v-if="typeError !== null" v-on:retryClicked="fetchData('conferences/fetchData', {page:1, withFilters: false})">		
			</empty-error-layout>
		</div>
	</div>

</template>

<script>


import VideoItem from './VideoItem'
import EmptyErrorLayout from './EmptyErrorLayout'
import Loader from './Loader'
import itemMixin from '../mixins/item_mixin.js'
import { mapGetters } from 'vuex'

export default {
	name: 'conferences',
	components: { VideoItem, Loader, EmptyErrorLayout },
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
			if(this.activeTab === 'conferences' && this.data.length === 0){
				this.fetchData(this.namespace + '/fetchData', {page: 1, withFilters: false})
			}
		}		
	},
	mounted () {
		console.log("Mounted Called")
		this.fetchData(this.namespace + '/fetchData', {page: 1, withFilters: true})
	}
	
}
</script>

<style scoped>
	
</style>