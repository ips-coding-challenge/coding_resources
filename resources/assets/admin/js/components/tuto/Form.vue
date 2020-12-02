<template>

  <div>
    <h2>{{ tuto ? 'Edit' : 'Add'}}</h2>

    <!-- Success Message  -->
    <div
      class="alert alert-success"
      v-if="onSuccess"
    >Tuto Edited!</div>

    <form method="POST">
      <div
        class="alert alert-danger"
        v-if="hasErrors"
      >
        <ul>
          <li
            v-for="(error, index) in errors"
            :key="index"
          >{{ error[0] }}</li>
        </ul>
      </div>

      <div class="row">
        <!-- LEFT COLUMN -->
        <div class="col-md-6">

          <input
            type="hidden"
            name="_method"
            value="PUT"
            v-if="tuto != null"
          >

          <input
            type="hidden"
            v-model="dataTuto.published_at"
          >

          <div class="form-group">
            <label for="title">Title</label>
            <input
              type="text"
              name="title"
              id="title"
              class="form-control"
              v-model="dataTuto.title"
            >
          </div>

          <div class="form-group">
            <label for="link">Youtube Link</label>
            <div class="row">
              <div class="col-xs-10">
                <input
                  type="text"
                  name="link"
                  id="link"
                  class="form-control"
                  v-model="dataTuto.youtube_id"
                >
              </div>
              <div class="col-xs-2">
                <input
                  type="text"
                  v-model="dataTuto.duration"
                  class="form-control"
                >
              </div>
            </div>

          </div>

          <div class="form-group">
            <label for="description">Description</label>
            <textarea
              name="description"
              id="description"
              cols="30"
              rows="5"
              v-model="dataTuto.description"
              class="form-control"
            ></textarea>
          </div>

          <div class="form-group">
            <label for="categories">Categories</label>
            <categories-input
              :categories="allCategories"
              :old-categories="tuto.categories"
            ></categories-input>

          </div>
          <!-- <div class="form-group">
            <label for="categories">Categories</label>
            <input
              type="text"
              name="categories"
              id="categories"
              class="form-control"
              v-model="dataTuto.categories"
            >
          </div> -->

        </div>

        <!-- RIGHT COLUMN -->
        <div class="col-md-6">

          <div class="form-group">
            <label for="langue">Langue</label>
            <select
              name="langue"
              id="langue"
              v-model="dataTuto.langue_id"
              class="form-control"
            >

              <option
                value="0"
                selected
              >Choose a language</option>
              <option
                v-for="langue in langues"
                :key="langue.id"
                :value="langue.id"
                :selected="tuto.langue_id === langue.id"
              >{{ langue.name }}</option>

            </select>
          </div>

          <!-- Tuto Parts -->
          <div
            v-for="(part, i) in dataParts"
            :key="i"
            class="tuto_part"
          >

            <div class="form-group">
              <label
                for="link"
                class="label_part"
              >Part {{ i+2 }}
                <span
                  class="glyphicon glyphicon-remove pull-right close_part_icon"
                  aria-hidden="true"
                  @click="deletePart(part)"
                ></span>
              </label>
              <div class="row">
                <div class="col-xs-10">
                  <input
                    type="text"
                    v-model="part.youtube_id"
                    id="link"
                    class="form-control"
                    @change="getYoutubeInfo(part, i)"
                  >
                </div>

                <div class="col-xs-2">
                  <input
                    type="text"
                    v-model="part.duration"
                    class="form-control"
                    :class="{'no-duration' : noDuration(part)}"
                  >
                </div>
              </div>

              <input
                type="hidden"
                v-model="part.part_number"
              >
            </div>

            <div class="form-group">
              <label for="title">Title</label>
              <input
                type="text"
                v-model="part.title"
                id="title"
                class="form-control"
              >
            </div>

          </div>

          <div class="form-group">
            <button
              class="btn btn-default"
              @click.prevent="addPart"
            >Add Part</button>
            <button
              class="btn btn-info"
              @click.prevent="openPlaylistModal"
            >Parts From Playlist</button>
          </div>
        </div>

      </div>
      <hr>
      <div class="row">
        <button
          class="btn btn-primary center-block"
          @click.prevent="sendForm"
        >Send</button>
      </div>
    </form>

    <playlist-modal v-on:addDataToForm="updateParts"></playlist-modal>

  </div>

</template>

<script>
import PlaylistModal from "./SearchPlaylistItemsModal.vue";
import CategoriesInput from "../category/CategoriesInput.vue";

export default {
  name: "tuto-form",
  components: { PlaylistModal, CategoriesInput },
  props: ["tuto", "langues", "parts"],
  data() {
    return {
      dataTuto: this.tuto,
      dataParts: this.parts,
      part: {},
      errors: null,
      onSuccess: false,
      allCategories: []
    };
  },
  computed: {
    formUrl() {
      return this.tuto === null ? "/admin/tuto" : "/admin/tuto/" + this.tuto.id;
    },
    hasErrors() {
      return this.errors !== null;
    }
  },
  mounted() {
    this.transformDataOnMounted();
    this.fetchCategories();
  },
  methods: {
    fetchCategories() {
      axios
        .get("/api/categories")
        .then(res => {
          res.data.data.forEach(cat => {
            this.allCategories.push(cat.name);
          });
        })
        .catch(err => {
          console.log(`Error while fetching categories`, err);
        });
    },
    // Permet de rajouter l'url complete youtube
    transformDataOnMounted() {
      this.dataTuto.youtube_id =
        "https://www.youtube.com/watch?v=" + this.dataTuto.youtube_id;
      if (this.dataTuto.langue_id === null) this.dataTuto.langue_id = 0;
      this.dataParts.forEach(part => {
        part["youtube_id"] =
          "https://www.youtube.com/watch?v=" + part.youtube_id;
      });
    },
    sendForm() {
      this.errors = null;
      this.onSuccess = false;

      //Need to do this extra step only in this form
      const selectedCategories = $("#selectedCategories").val();
      this.dataTuto.categories = selectedCategories;

      axios
        .put("/admin/tuto/" + this.tuto.id, {
          tuto: this.dataTuto,
          parts: this.dataParts
        })
        .then(response => {
          window.location.replace("/admin/tuto/propositions");
          // window.scrollTo(0,0)
          // this.onSuccess = true
        })
        .catch(error => {
          console.log(error.response);
          window.scrollTo(0, 0);
          this.errors = error.response.data.errors;
        })
        .then(() => {
          //On Complete
        });
    },
    addPart() {
      let part = { title: "", youtube_id: "", duration: "" };
      this.dataParts.push(part);
    },
    deletePart(part) {
      let index = this.dataParts.findIndex(el => {
        return el.youtube_id === part.youtube_id;
      });

      this.dataParts.splice(index, 1);
    },
    getYoutubeInfo(part, i) {
      axios
        .get("/api/youtube_info?url=" + part.youtube_id)
        .then(res => {
          part.title = res.data.title;
          part.duration = res.data.duration;
          part.part_number = i + 2; //Démarre a 0 et la premiere partie est prise par le "tuto"
        })
        .catch(error => {})
        .then(() => {});
    },
    showDuration(part) {
      if (part.duration.length > 0) return `( ${part.duration} )`;
    },
    openPlaylistModal() {
      $("#playlistModal").modal("show");
    },
    updateParts(newParts) {
      console.log("Called ?");
      this.dataParts = newParts;
    },
    noDuration(part) {
      return part.duration === "00:00";
    }
  }
};
</script>

<style scoped>
.tuto_part {
  margin: 10px 0;
  padding: 10px;
  background-color: #eaeaea;
}
.label_part {
  width: 100%;
}
.close_part_icon {
  font-size: 2rem;
  cursor: pointer;
}
.close_part_icon:hover {
  color: black;
}
.no-duration {
  background-color: #dc4441;
  color: white;
}
</style>