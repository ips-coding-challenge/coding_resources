<template>
	
	<div class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Modify Category</h4>
					<div class="alert alert-danger" role="alert" v-if="errors != null">
						<ul>
							<li v-for="error in errors">{{ showError(error) }}</li>
						</ul>
					</div>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<input type="text" class="form-control" v-model="category.name"/>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" @click.prevent="updateCategory()">Update category</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</template>

<script>
	import EventBus from '../event-bus.js'

	export default {
		name: 'category-modal',
		data () {
			return {
				category: '',
				errors: null
			}
		},
		created () {
			EventBus.$on('openModal', payload =>  {				
				this.category = payload
			})
		},
		methods : {
			updateCategory () {
				this.errors = null
				axios.patch("/admin/category/" + this.category.id, this.category).then ( response => {
					window.location.replace("/admin/category");
				}).catch( error => {
					console.log(error.response)
					this.errors = error.response.data
					
				})
			},
			showError(error){
				if(error.constructor === Array){
					return error[0]
				}else{
					return error
				}
			}
		}
	}
</script>