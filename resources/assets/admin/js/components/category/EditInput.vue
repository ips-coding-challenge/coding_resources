<template>
	
	<button class="btn btn-info" @click="openModal(category)">Edit</button>

</template>

<script>

import EventBus from '../event-bus.js'

	export default{
		name:'edit-input',
		props: ['category'],
		data () {
			return {

			}
		},
		methods: {
			openModal(category) {
				EventBus.$emit('openModal', category)
				$('.modal').modal('show')
			}
		}
	}
</script>