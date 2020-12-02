const state = {
	data: [],
	currentPage: 1,
	total: 0,
	lastPage: 1,
	isEmpty: false,
	error: false
}

const mutations = {
	SET_DATA (state, data) {
		state.data = state.data.concat(data.items)
	},
	SET_CURRENT_PAGE ( state, currentPage ){
		state.currentPage = currentPage
	},
	SET_TOTAL (state, total) {
		state.total = total
	},
	SET_LAST_PAGE (state, lastPage) {
		state.lastPage = lastPage
	},
	IS_EMPTY ( state, isEmpty ){
		state.isEmpty = isEmpty
	},
	SET_ERROR ( state, error ){
		state.error = error
	}
}

const actions = {
	fetchData ({ commit }, params) {
		return axios.get('/api/search', {params: params}).then ( response => {
			if(response.data.total === 0) { 
				commit('IS_EMPTY', true)
			} else {
				commit('IS_EMPTY', false)
			}
			commit('SET_DATA', {items: response.data.data })
			commit('SET_CURRENT_PAGE', response.data.current_page)
			commit('SET_TOTAL', response.data.total)
			commit('SET_LAST_PAGE', response.data.last_page)
		})
	},
	setError( { commit }, error ){
		commit("SET_ERROR", error)
	},
	isEmpty( { commit }, isEmpty) {
		commit('IS_EMPTY', isEmpty)
	}
}

const getters = {
	data : state => state.data,
	currentPage : state => state.currentPage,
	lastPage: state => state.lastPage,
	isEmpty: state => state.isEmpty,
	error: state => state.error
}

export default {
	namespaced: true,
	state,
	mutations,
	actions,
	getters
}