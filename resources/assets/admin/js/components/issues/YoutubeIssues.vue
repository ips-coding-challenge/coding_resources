<template>
<div>
    <h2>Issue with Youtube Video</h2>
    <hr>
    <div class="alert alert-success" v-if="conferenceDeleted">Conference deleted</div>
    <div class="alert alert-danger" v-if="error != null">An error occurred</div>
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <input type="text" v-model="channel" class="form-control">
                <span class="input-group-btn">
                    <button class="btn btn-default" @click.prevent="fetchData">Search</button>
                </span>
            </div>
        </div>
    </div>   
    
    <div v-show="loading">Loading...</div>
    <hr>
    <table class="table table-striped" v-if="conferences.length > 0">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Title</th>
                    <th>Youtube Id</th>
                    <th>Duration</th>
                    <th>Valid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr :class="{'no-categories': conferences.length == 0}" v-for="conf in conferences" :key="conf.id">
                    <td>{{ conf.id }}</td>
                    <td>
                        {{ conf.title }}
                    </td>
                    <td>{{ conf.youtube_id }}</td>
                    <td>{{ conf.duration }}</td>
                    <td>{{ conf.is_valid ? 'true' : 'false' }}</td>
                    <td>
                        <button class="btn btn-danger" onClick="javascript: return confirm('Are You Sure ?');" @click.prevent="deleteConf(conf)">Delete</button>
                    </td>
                </tr>
            </tbody>

        </table>
</div>
</template>

<script>
export default {
  name: "youtube-issues",
  data() {
    return {
      conferences: [],
      channel: "Coding Tech",
      loading: false,
      conferenceDeleted : false,
      error: null
    };
  },
  methods: {
    fetchData() {
        this.loading = true
      axios
        .get("/admin/youtube-issues?channel=" + this.channel)
        .then(response => {
          console.log(response);
          this.conferences = response.data;
        })
        .catch(error => {
          console.log(error);
        }).then( () => {
            this.loading = false
        })
    },
    deleteConf(conf) {
        this.conferenceDeleted = false
        this.error = null
        axios.delete('/admin/conference/' + conf.id).then( response => {
            const index = this.conferences.indexOf(conf)
            if(index !== -1) this.conferences.splice(index, 1)
            this.conferenceDeleted = true            
        }).catch(error => {
            this.error = error
            console.log(error)
        })
    }
  }
};
</script>
