<template>
	<div class="form-group" :class="{'has-error' : toVerify }">
		<label for="title">Title</label>
		<input type="text" id="title" name="title" v-model="title" class="form-control" autocomplete="off">
		<span class="help-block">{{ error }}</span>
	</div>

</template>

<script>
export default {
	name: "title-input",
	data () {
		return {
			title: "",
			toVerify: false,
			error: ""
		}
	},
	watch: {
		title () {
			this.checkTitle()
		}
	},
	methods: {
		checkTitle(){

			this.toVerify = false
			const type = $('#type').find(":selected").val()

			console.log(type)
			// Just return if it's not an article or a book
			if(type !== "article" && type !== "book") return false

			axios.get(`/api/checkTitle?type=${type}&title=${this.title}`).then ( response => {
				console.log(response)
			}).catch ( error => {
				const response = error.response

				if(response.status === 422){
					this.toVerify = true
					this.error = response.data.error
				}
				console.log(error.response)
			})
		}
	}
}
</script>