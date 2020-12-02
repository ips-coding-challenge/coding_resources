<template>
	<!-- Empty Layout -->
	<div class="mdl-grid error_container">
		<div class="error-msg" v-if="isEmpty">
			<h3>No result found! Try to remove some filters</h3>
		</div>
		<div class="error-msg" v-if="isError">
			<h3>An error occurred! Please Retry</h3>
			<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" @click.prevent="retryClicked">
				Retry
			</button>
		</div>
	</div>
</template>

<script>
export default {
	name: 'empty-error-layout',
	props: ['type'],
	computed: {
		isEmpty () {
			return this.type === "empty"
		},
		isError () {
			return this.type === "error"
		}
	},
	methods: {
		retryClicked () {
			this.$emit('retryClicked')
		}
	}
}
</script>

<style scoped lang="scss">
	
	.error_container .error-msg {
		margin: 0 auto;
		h3 {
			color: rgba(0,0,0,.54);
			text-align: center;
		}

		button {
			display: block;
			margin: 0 auto;
		}
	}

</style>