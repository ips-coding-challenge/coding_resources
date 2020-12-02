<template>
  <div v-show="description.length > 0">
    <div class="mdl-card mdl-shadow--2dp card-description" v-html="description" ref="description" :class="{'shorten' : shorten }"></div>
    <div class="showMore" v-show="showMore" @click="toggleDescription">{{ textButton }}</div>
  </div>
</template>

<script>
export default {
  name: "description",
  props: ["description"],
  data() {
    return {
      showMore: false,
      showMoreClicked: false,
      height: 0
    };
  },
  computed: {
    textButton() {
      return this.showMoreClicked ? "Less" : "More";
    },
    shorten() {
      if (this.showMore) {
        return !this.showMoreClicked;
      }
    }
  },
  mounted() {
    this.getDescriptionHeight();
  },
  methods: {
    getDescriptionHeight() {
      this.height = this.$refs.description.offsetHeight;
      if (this.height > 100) {
        this.showMore = true;
      }
    },
    toggleDescription() {
      this.showMoreClicked = !this.showMoreClicked;
    }
  }
};
</script>

<style lang="scss" scoped>
.card-description {
  margin: 0 auto;
  width: 100%;
  padding: 16px;
  margin-top: 20px;
  font-size: 15px;
  min-height: auto;
  line-height: 24px;
  background-color: #dddddd;
  color: #313131;
}
.shorten {
  max-height: 100px;
  overflow: hidden;
}
.showMore {
  cursor: pointer;
  font-size: 16px;
  font-weight: bold;
  padding: 8px;
  user-select: none;
}
</style>

