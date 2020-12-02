<template>
	
	<video-item :for-search="true" type="conference" :item="item" v-if="itemType === 'conference'"></video-item>
	<article-item :for-search="true" :article="item" v-else-if="itemType === 'article'"></article-item>
	<video-item :for-search="true" type="tuto" :item="item" v-else-if="itemType === 'tuto'"></video-item>
	<book-item :for-search="true" :book="item" v-else-if="itemType === 'book'"></book-item>

</template>

<script>
import VideoItem from './VideoItem'
import ArticleItem from './ArticleItem'
import BookItem from './BookItem'

	export default {
		name:"search-item",
		props: ['item', 'itemType'],
		components: {VideoItem, ArticleItem, BookItem}
	}
</script>