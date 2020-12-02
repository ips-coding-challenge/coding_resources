<template>
  <div>
    <div class="form-group">
      <label for="link">Link <div
          class="loader"
          v-if="loading"
        ></div></label>
      <input
        type="text"
        id="link"
        v-model="link"
        name="link"
        class="form-control"
        autocomplete="off"
      >
    </div>
  </div>
</template>

<script>
export default {
  name: "link-input-for-youtube",
  props: ["old"],
  data() {
    return {
      link: this.old ? this.old : "",
      loading: false,
      amazonTag: "ipsacoustic-21"
    };
  },
  watch: {
    link() {
      this.getYoutubeInfo();
    }
  },
  mounted() {
    this.listenSelect();
  },
  methods: {
    getYoutubeInfo() {
      let type = $("#type")
        .find(":selected")
        .val();

      if (!(type === "conference" || type === "tuto")) return;

      this.disable(true);
      this.loading = true;

      axios
        .get("/api/youtube_info?url=" + this.link)
        .then(res => {
          console.log("Response from youtube info", res.data);
          $("#title").val(res.data.title);
        })
        .catch(error => {
          console.log("Error fetching youtube infos", error);
        })
        .then(() => {
          this.disable(false);
          this.loading = false;
        });
    },
    disable(bool) {
      $(".btn").attr("disabled", bool);
    },
    listenSelect() {
      $("#type").on("change", () => {
        const value = $("#type").val();

        if (value === "book") {
          this.link =
            "https://www.amazon.com/dp/#TO_REPLACE#/?tag=" + this.amazonTag;
        }
      });
    }
  }
};
</script>
