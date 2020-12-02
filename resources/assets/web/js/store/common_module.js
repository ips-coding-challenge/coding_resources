const state = {
	activeTab: 'conferences',
	searchTerm: ''
}

const mutations = {
	SET_ACTIVE_TAB (state, activeTab){
		state.activeTab = activeTab
	},
	SET_SEARCH_TERM (state, searchTerm) {
		state.searchTerm = searchTerm
	}
}

const actions = {
	setActiveTab ({commit}, activeTab) {
		commit('SET_ACTIVE_TAB', activeTab)
	},
	setSearchTerm ({commit}, searchTerm) {
		commit("SET_SEARCH_TERM", searchTerm)
	}
}

const getters = {
	activeTab: state => state.activeTab,
	searchTerm: state => state.searchTerm
}

export default {
	namespaced: true,
	state,
	mutations,
	actions,
	getters
}