<template>
  <div class="mdl-grid">
        <div class="mdl-cell mdl-cell--6-col-desktop mdl-cell--3-offset-desktop mdl-cell--12-col-tablet">
            <h2>Add a link</h2>
            <hr>

            <div class="mdl-selectfield mdl-js-selectfield mdl-selectfield--floating-label" :class="{'is-invalid' : typeError !== undefined, 'is-dirty': type !== ''}">
              <select id="myselect" name="myselect" class="mdl-selectfield__select" v-model="type">
                <option value="conference">Conference</option>
                <option value="article">Article</option>
                <option value="tuto">Tuto</option>
                <option value="book">Book</option>
              </select>
              <label class="mdl-selectfield__label" for="myselect">* Select a type</label>
              <span class="mdl-selectfield__error" v-show="typeError !== undefined">{{ typeError }}</span>
              <span class="select-helper" v-show="type === 'tuto' && typeError === undefined">If it's a written tuto, choose article instead</span>
            </div>
            <!-- Link -->
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" :class="{'is-invalid' : linkError !== undefined, 'is-dirty': title !== ''}">
                <input class="mdl-textfield__input" type="url" v-model.trim="link">
                <label class="mdl-textfield__label" for="sample1">{{ textLink }}</label>
                <span class="mdl-textfield__error" v-show="linkError !== undefined">{{ linkError }}</span>
            </div>    

            <!-- Title -->
            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label" :class="{'is-invalid' : titleError !== undefined, 'is-dirty': title !== ''}" ref="titleInput">
                <input class="mdl-textfield__input" type="text" v-model.trim="title" :disabled="youtubeLoading">
                <label class="mdl-textfield__label" for="sample1">* Title</label>
                <span class="mdl-textfield__error" v-show="titleError !== undefined">{{ titleError }}</span>
            </div> 
            <loader v-show="youtubeLoading"></loader>
            <button class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" 
                @click.prevent="sendForm" :disabled="disabled">Add</button>
            <loader v-show="loading"></loader>    
        </div>

        <!-- snackbar -->
			<div id="add-snackbar" class="mdl-js-snackbar mdl-snackbar" ref="snackbar">
				<div class="mdl-snackbar__text"></div>
				<button class="mdl-snackbar__action" type="button"></button>
			</div>
    </div>
</template>

<script>
import Loader from "../../components/Loader.vue";

export default {
  name: "add-form",
  components: { Loader },
  data() {
    return {
      type: "",
      link: "",
      title: "",
      errors: null,
      youtubeLoading: false,
      loading: false
    };
  },
  computed: {
    textLink() {
      if (this.type === "conference" || this.type === "tuto") {
        return "* Youtube link";
      } else {
        return "* Link";
      }
    },
    disabled() {
      return this.type === "" || this.link === "" || this.title === "";
    },
    typeError() {
      if (this.errors !== null && this.errors.type !== undefined) {
        return this.errors.type[0];
      }
    },
    linkError() {
      if (this.errors !== null && this.errors.link !== undefined) {
        return this.errors.link[0];
      }
    },
    titleError() {
      if (this.errors !== null && this.errors.title !== undefined) {
        return this.errors.title[0];
      }
    }
  },
  watch: {
    link() {
      if (this.youtubeLoading) return;
      this.getYoutubeInfo();
    }
  },
  methods: {
    watchType() {
      this.type = document.querySelector("#type").getAttribute("data-val");
    },
    sendForm() {
      this.errors = null
      const data = {
        type: this.type,
        title: this.title,
        link: this.link
      };
      this.loading = true
      axios.post("/api/propositions", data).then(response => {
          console.log(response);
          const data = {
            message: "Thanks you!",
            timeout: 2000
          }
          this.$refs.snackbar.MaterialSnackbar.showSnackbar(data)
          this.clearForm();
        }).catch(error => {
          console.log(error);
          if(error.response.data !== undefined){
            this.errors = error.response.data
          }          
        }).then( () => {
          this.loading = false
        })
    },
    clearForm() {
      const typeSelected = document.querySelector(".mdl-selectfield__box-value")
      typeSelected.innerHTML = ''
      this.type = ""
      this.link = ""
      this.title = ""
    },
    getYoutubeInfo() {
      if (!(this.type === "conference" || this.type === "tuto")) return;

      this.youtubeLoading = true;

      axios.get("/api/youtube_info?url=" + this.link).then(res => {
          this.$refs.titleInput.classList.add("is-dirty");
          this.title = res.data.title;
        }).catch(error => {
          console.log(error);
        }).then(() => {
          this.youtubeLoading = false;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.mdl-selectfield {
  display: block;
  width: 450px;
  margin: 0 auto;
  margin-bottom: 10px;

  .select-helper {
    color: #616161;
    position: absolute;
    font-size: 12px;
    margin-top: 3px;
    display: block;
    white-space: nowrap;
}
}
.mdl-textfield {
  width: 450px;
  display: block;
  margin: 0 auto;
  margin-bottom: 10px;
}
.mdl-button {
  margin: 20px auto;
  display: block;
}
</style>
