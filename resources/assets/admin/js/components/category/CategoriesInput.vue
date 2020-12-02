<template>
  <div>
    <vue-select
      multiple
      :close-on-select="false"
      id="categories"
      name="categories"
      v-model="selected"
      :options="categories"
      taggable
    ></vue-select>

    <input
      id="selectedCategories"
      type="hidden"
      name="categories"
      :value="join"
    >
  </div>
</template>

<script>
// import Vue from vue;
import VueSelect from "vue-select";
// Vue.component('v-select')
export default {
  name: "categories-input",
  props: ["categories", "oldCategories"],
  components: { VueSelect },
  mounted() {
    if (this.oldCategories.length > 0) {
      const old = this.oldCategories.split(",");
      console.log(`Old`, old);
      if (old.length > 0) {
        old.forEach(cat => {
          this.selected.push(cat);
        });
      }
    }
  },
  data() {
    return {
      selected: []
    };
  },
  computed: {
    join() {
      return this.selected.length > 0 ? this.selected.join() : "";
    }
  }
};
</script>
<style lang="sass" scoped>

</style>

