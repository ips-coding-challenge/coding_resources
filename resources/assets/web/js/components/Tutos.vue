<template>
	<div class="container__items">
		<div class="container__tutos" 
			v-infinite-scroll="loadMore" 
			infinite-scroll-disabled="busy" 
			infinite-scroll-distance="150"
		>

			<loader v-show="isLoading"></loader>

			<div class="mdl-grid"  v-if="typeError === null">
				<video-item type="tuto" :item="tuto" v-for="tuto in data" :key="tuto.id"></video-item>            
			</div>

			<loader v-show="busy && !hasError"></loader>

			<!-- Empty / Error layout -->
			<empty-error-layout :type="typeError" v-if="typeError !== null" v-on:retryClicked="fetchData('tutos/fetchData', {page:1, withFilters: false})">		
			</empty-error-layout>
		</div>
	</div>
</template>

<script>

import VideoItem from './VideoItem'
import Loader  from './Loader'
import EmptyErrorLayout from './EmptyErrorLayout'
import itemMixin from '../mixins/item_mixin.js'
import { mapGetters } from 'vuex'

export default {
	name: 'tutos',
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
			if(this.activeTab === 'tutos' && this.data.length === 0){
				this.fetchData(this.namespace + '/fetchData', {page: 1, withFilters: false})
			}
		}
	}

}
</script>

<style scoped>

</style>