<template>

	<div>
		<h3>Add a book</h3>
		<!-- Input to fetch infos from amazon api -->
		<div class="form-inline">
			<div class="form-group">
				<input type="text" v-model="productId" class="form-control" placeholder="Amazon productID">
			</div>

			<div class="form-group">
				<button class="btn btn-default" @click.prevent="fetchBook">Fetch infos</button>
			</div>

		</div>
		<hr>
		<!-- Form -->
		<form method="POST">


			<div class="alert alert-danger" v-if="errors != null">
				<ul>
					<li v-for="(error, index) in errors" :key="index">{{ error[0] }}</li>
				</ul>
			</div>

			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" id="title" class="form-control" v-model="title">
			</div>

			<div class="form-group">
				<label for="author">Author</label>
				<input type="text" id="author" class="form-control" v-model="author">
			</div>


			<div class="form-group">
				<label for="link">Link</label>
				<input type="url" id="link" class="form-control" v-model="link">
			</div>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea name="description" id="description" cols="30" rows="10"
				class="form-control" v-model="description"></textarea>
			</div>

			<div class="form-group">
				<label for="cover">Cover</label>
				<input type="url" name="cover" id="cover" class="form-control" v-model="cover">
			</div>


			<div class="form-group">
				<label for="categories">Categories (don't click on suggestions)</label>
				<input type="text" name="categories" id="categories" class="form-control" v-model="categories">
			</div>

			<div class="form-group">
				<label for="langue">Langue</label>
				<select name="langue" id="langue" v-model="langue_id" class="form-control">

					<option value="0" selected>Choose a language</option>					
					<option v-for="langue in langues" :value="langue.id" :selected="langue_id === langue.id" :key="langue.id">{{ langue.name }}</option>

				</select>
			</div>

			<div class="form-group">
				<button class="btn btn-primary" @click.prevent="sendForm">Send</button>
			</div>

		</form>
	</div>
	
</template>

<script>
export default {

	name:"quick-add-book",
	props: ['langues'],
	data () {
		return {
			errors: null,
			title: '',
			author: '',
			link: '',
			description: '',
			cover: '',
			categories: '',
			langue_id: 0,
			itemFromAmazon: null,
			amazonTag: "codingresourc-20",
			productId: ''
		}
	},
	methods: {
		sendForm() {
			axios.post('/admin/book', this.createBook()).then(response => {
				console.log(response)
				console.log("ok")
				window.location.replace('/admin/book/propositions')
			}).catch( error => {
				window.scrollTo(0,0)
				console.log(error.response)
				this.errors = error.response.data
			})
		},
		fetchBook(){
			axios.get('/api/amazon/' + this.productId).then( response => {				
				this.itemFromAmazon = response.data.data
				this.setValues()
				this.productId = ''
			}).catch( error => {
				
				console.log(error.response.data)
			})
		},
		setValues () {
			this.title = this.itemFromAmazon.ItemAttributes.Title
			this.author = this.itemFromAmazon.ItemAttributes.Author
			if(Array.isArray(this.author)) this.author = this.author.join(',')
			this.link = "https://www.amazon.com/dp/" + this.productId + "/?tag=" + this.amazonTag
			this.cover = this.itemFromAmazon.LargeImage.URL
		},
		createBook () {
			return {
				title: this.title,
				author: this.author,
				link: this.link,
				description: this.description,
				cover: this.cover,
				categories: this.categories,
				langue: this.langue_id
			}
		}
	}
}
</script>