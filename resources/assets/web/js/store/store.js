import Vue from 'vue'
import Vuex from 'vuex'
import common from './common_module.js'
import conferences from './conferences_module.js'
import articles from './articles_module.js'
import tutos from './tutos_module.js'
import books from './books_module.js'
import filters from './filters_module.js'
import search from './search_module.js'

Vue.use(Vuex)

const store = new Vuex.Store({
	modules: {
		common,
		conferences,
		articles,
		tutos,
		books,
		filters,
		search
	}
})

export default store