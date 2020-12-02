export default {
	data () {
		return {
			isLoading: false,
			busy: false,
			isActive: false
		}
	},
	computed: {
		data () {
			return this.$store.getters[this.namespace + '/data']
		},
		currentPage () {
			return this.$store.getters[this.namespace + '/currentPage']
		},
		lastPage () {
			return this.$store.getters[this.namespace + '/lastPage']
		},
		isEmpty () {
			return this.$store.getters[this.namespace + '/isEmpty']
		},
		hasError () {
			return this.$store.getters[this.namespace + '/error']
		},
		typeError () {
			if(this.data.length == 0){
				if(this.isEmpty){
					return "empty"
				}else if(this.hasError){
					return "error"
				}
			}else{
				return null
			}

		},
		hasMore () {
			return this.currentPage !== this.lastPage && this.lastPage !== 0
		},
		selectedCategories () {
			return this.$store.getters['filters/selectedCategories']
		},
		searchLaunched () {
			return this.$store.getters['filters/searchLaunched']
		},
		activeTab () {
			return this.$store.getters['common/activeTab']
		}
	},	
	methods: {
		fetchData (action, params) {
			
			this.isLoading = true

			this.$store.dispatch(this.namespace + '/setError', false)
			this.$store.dispatch(this.namespace + '/isEmpty', false)

			this.$store.dispatch(action, {
				page: params.page,
				categories: this.selectedCategories,
				withFilters: params.withFilters
			}).then( () => {
				this.isLoading = false	
				this.busy = false
				this.$store.dispatch('filters/searchLaunched', false)	
							
			}).catch(error => {
				console.log(error)
				this.isLoading = false
				this.$store.dispatch(this.namespace + '/setError', true)
				//To avoid fetching next page if an error occurred
				// this.busy = true
			})


		},
		loadMore() {
			
			const activeTab = document.querySelector(this.tab)
			if(!activeTab.classList.contains('is-active')) {
				return
			}

			if(this.currentPage + 1 > this.lastPage) {
				return
			}

			this.busy = true
			this.fetchData(this.namespace + '/fetchData', {page: this.currentPage + 1, withFilters: false})
			
		},
		tabIsActive () {
			const activeTab = document.querySelector(this.tab)
			return activeTab.classList.contains('is-active')
		}
	}
}