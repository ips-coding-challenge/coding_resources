const state = {
	categories: [],
	selectedCategories: [],
	isOpen: false,
	searchLaunched: false,
	suggestions: [],
	searchTerm: ''
}

const mutations = {
	FETCH_FROM_COOKIE(state, selectedCategories) {
		state.selectedCategories = selectedCategories
	},
	FETCH_CATEGORIES(state, categories) {
		state.categories = categories
	},
	SELECT(state, category){
		state.selectedCategories.push(category)
	},
	DESELECT(state, category){
		const index = state.selectedCategories.indexOf(category)
		console.log(index)
		state.selectedCategories.splice(index, 1)
	},
	IS_OPEN(state, isOpen){
		state.isOpen = isOpen
	},
	SEARCH_LAUNCHED(state, launched) {
		state.searchLaunched = launched
	},
	SUGGESTIONS(state, suggestions){
		state.suggestions = suggestions
	},
	SEARCH_TERM(state, searchTerm){
		state.searchTerm = searchTerm
	}
}

const actions = {
	fetchFromCookie({commit}, selectedCategories) {
		commit('FETCH_FROM_COOKIE', selectedCategories)
	},
	fetchCategoriesFromCache({commit}, categories) {
		commit('FETCH_CATEGORIES', categories)
	},
	fetchCategories ({commit}) {
		return axios.get('/api/categories').then( response => {
			commit('FETCH_CATEGORIES', response.data.data)
		})
	},
	select({commit}, category){
		commit('SELECT', category)
	},
	deselect({commit}, category){
		commit('DESELECT', category)
	},
	isOpen({commit}, isOpen){
		commit("IS_OPEN", isOpen)
	},
	searchLaunched({commit}, launched){
		commit('SEARCH_LAUNCHED', launched)
	},
	autocomplete({commit}, searchTerm) {

		return axios.get('/api/suggestions?q=' + searchTerm).then( response => {
			console.log(response)
			commit('SUGGESTIONS', response.data.data)
			commit('SEARCH_TERM', searchTerm)			
		})
	},
	resetSuggestions({commit}){
		commit('SUGGESTIONS', [])
	}
}

const getters = {
	categories: state => state.categories,
	selectedCategories: state => state.selectedCategories,
	isOpen: state => state.isOpen,
	searchLaunched: state => state.searchLaunched,
	suggestions: state => state.suggestions
}

export default {
	namespaced: true,
	state, 
	mutations,
	actions,
	getters
}