<template>
	
	<div class="container__suggestions">
		<ul>
			<li v-for="(item, index) in suggestions" :key="index">
				<a @click.prevent="launchSearch(item.title)">{{ item.title }}</a>
				<div class="suggestions-type">{{ item.type}}</div>
			</li>
		</ul>
	</div>

</template>

<script>
	export default {
		name: 'suggestions',
		props: ['suggestions'],
		watch: {
			suggestions () {
				if(this.suggestions.length == 0){
					const container = document.querySelector('.container__suggestions')
					container.style.display = 'none'
				}
			}
		},
		methods: {
			launchSearch (title) {
				window.location.href = "/search?q=" + encodeURIComponent(title)
			}
		}
	}
</script>

<style lang="scss" scoped>
	
	.container__suggestions {
		display: none;
		position: fixed;
		padding: 0 8px;
		top: 56px;
		left: 0;
		right: 0;
		bottom:0;
		z-index:3;
		opacity:0.97;
		background-color: #607d8b;
		overflow-y: scroll;

		ul {
			margin: 0;
			padding: 0;
		}

		li {
			border-bottom: 1px solid #455a65;
			text-align:center;
			padding: 16px;
			font-size:15px;

			&:last-child {
				border-bottom: none;
			}
			&:hover{
				background-color: #455a65;
				cursor:pointer;
			}
			a {
				color: inherit;
				text-decoration: inherit;
			}
		}
	}

	.suggestions-type {
		color: #f2734c;
		font-weight:bold;
	}

</style>