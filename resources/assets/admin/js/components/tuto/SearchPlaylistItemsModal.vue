<template>

  <div
    class="modal fade"
    tabindex="-1"
    role="dialog"
    id="playlistModal"
  >
    <div
      class="modal-dialog"
      role="document"
    >
      <div class="modal-content">
        <div class="modal-header">
          <button
            type="button"
            class="close"
            data-dismiss="modal"
            aria-label="Close"
          ><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title">Search for items in playlist</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">

            <label for="playlistId">Playlist ID:</label>
            <div class="input-group">
              <input
                type="text"
                class="form-control"
                v-model="playlistId"
                id="playlistId"
              >
              <span class="input-group-btn">
                <button
                  class="btn btn-default"
                  type="button"
                  @click.prevent="getPartsFromPlaylist"
                >Search!</button>
              </span>
            </div><!-- /input-group -->

            <div v-show="isLoading">Searching...</div>

            <div
              v-for="(temp, index) in temporary"
              :key="index"
            >
              <span>{{ temp.part_number }} - <strong>{{ temp.title }}</strong>( {{ temp.duration }} )</span>
            </div>

          </div>
        </div>
        <div class="modal-footer">
          <button
            type="button"
            class="btn btn-default"
            data-dismiss="modal"
          >Close</button>
          <button
            type="button"
            class="btn btn-primary"
            @click.prevent="addDataToForm"
          >Ok</button>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

</template>

<script>
export default {
  name: "playlist-modal",
  data() {
    return {
      newParts: [],
      playlistId: "",
      isLoading: false,
      temporary: []
    };
  },
  methods: {
    getPartsFromPlaylist() {
      this.isLoading = true;
      // const playlistId = "PLEubh3Rmu4tnqJw1dyKt5HQGPfvk40eZP"
      axios
        .get("/api/playlist_parts/" + this.playlistId)
        .then(res => {
          console.log(res);
          let request = [];
          let allParts = res.data;
          allParts.shift();
          // setTimeout(() => {

          // })
          allParts.forEach((part, i) => {
            part["duration"] = "00:00";

            request.push(
              axios
                .get("/api/video_duration/" + part.youtube_id)
                .then(response => {
                  console.log(response.data);
                  part["duration"] = response.data;
                })
                .catch(error => {
                  console.log(error.message);
                  console.log("Error when fetching video duration");
                })
            );
            part["youtube_id"] =
              "https://www.youtube.com/watch?v=" + part.youtube_id;
              this.temporary.push(part);
            // setTimeout(() => {
              
            // }, 500);
          });

          axios.all(request).then(() => {
            this.newParts = allParts;
          });
        })
        .catch(error => {
          console.log(error);
        })
        .then(() => {
          this.isLoading = false;
        });
    },
    addDataToForm() {
      if (this.isLoading) return;

      // this.$parent.dataParts = this.newParts

      $("#playlistModal").modal("hide");

      this.$emit("addDataToForm", this.newParts);
    }
  }
};
</script>