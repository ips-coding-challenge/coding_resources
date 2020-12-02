<template>
  <div
    class="container__filters"
    v-show="isOpen"
  >
    <!-- LOADER -->
    <div class="loading__container">
      <div
        class="mdl-spinner mdl-spinner--single-color mdl-js-spinner is-active"
        v-show="isLoading"
      ></div>
    </div>

    <div class="container__categories">
      <button
        type="button"
        class="mdl-chip"
        v-for="cat in categories"
        :key="cat.id"
        :class="{'pressed': selected(cat.id) }"
        @click.prevent="selectCat($event, cat.id)"
      >
        <span class="mdl-chip__text">{{ cat.name }}</span>
      </button>
    </div>
    <div class="actions">
      <span @click.prevent="closeFilters"><i class="material-icons">clear</i></span>
      <span @click.prevent="launchFilters"><i class="material-icons">done</i></span>
    </div>
  </div>
</template>

<script>
import Cookie from "js-cookie";
import localforage from "localforage";
import { mapGetters } from "vuex";

export default {
  name: "filters",
  data() {
    return {
      isLoading: true
    };
  },
  computed: {
    categories() {
      return this.$store.getters["filters/categories"];
    },
    isOpen() {
      return this.$store.getters["filters/isOpen"];
    },
    selectedCategories() {
      return this.$store.getters["filters/selectedCategories"];
    }
  },
  mounted() {
    console.log(`Mounted called`);
    this.getCategoriesFromCache();
  },
  watch: {
    isOpen() {
      const container = document.querySelector(".container__filters");

      if (!this.isOpen) {
        // container.classList.remove('open')
        container.classList.remove("full");
        const fab = document.querySelector(".fab-filters");
        fab.style.display = "block";
      }

      if (this.isOpen) {
        if (!this.categories) {
          this.$store.dispatch("filters/fetchCategories").then(() => {
            localforage.setItem("categories", this.categories).then(() => {
              var inThirtyMinutes = new Date(
                new Date().getTime() + 30 * 60 * 1000
              );
              Cookie.set("cached_categories", true, {
                expires: inThirtyMinutes
              });
            });
            this.isLoading = false;
            this.$nextTick(() => {
              this.toggleFilter(container);
            });
          });
        } else {
          this.$nextTick(() => {
            this.toggleFilter(container);
          });
        }
      }
    }
  },
  methods: {
    toggleFilter(container) {
      const body = document.querySelector("body");
      // container.classList.add('open')
      console.log("container height = " + container.offsetHeight);
      console.log("body height = " + body.offsetHeight / 2);
      if (container.offsetHeight > body.offsetHeight / 1.5) {
        container.classList.add("full");
      }
    },
    selectCat(e, category) {
      const index = this.selectedCategories.indexOf(category);

      if (this.selectedCategories.indexOf(category) === -1) {
        this.$store.dispatch("filters/select", category);
      } else {
        e.target.parentNode.classList.remove("pressed");
        this.$store.dispatch("filters/deselect", category);
      }
    },
    selected(cat) {
      return this.selectedCategories.indexOf(cat) !== -1;
    },
    launchFilters() {
      const layout = document.querySelector(".mdl-layout__content");
      this.$store.dispatch("filters/searchLaunched", true);
      this.closeFilters();
      Cookie.set(
        "pref_categories",
        { selectedCategories: this.selectedCategories },
        { expires: 365 }
      );
      setTimeout(() => {
        layout.scrollTo(0, 0);
      }, 200);
    },
    closeFilters() {
      this.$store.dispatch("filters/isOpen", false);
    },
    getCategoriesFromCache() {
      // if (Cookie.get("cached_categories") === undefined) return;
      localforage
        .getItem("categories")
        .then(value => {
          console.log(`categories`, value);
          this.$store.dispatch("filters/fetchCategoriesFromCache", value);
        })
        .catch(e => {
          console.log("Error while fetching categories from cache " + e);
        })
        .then(() => {
          this.isLoading = false;
        });
    }
  }
};
</script>

<style lang="scss" scoped>
.container__filters {
  padding-top: 20px;
  overflow-y: scroll;
  z-index: 3;
  position: absolute;
  background-color: rgb(255, 110, 64);
  min-height: 200px;
  bottom: 0;
  right: 0;
  left: 0;
  transition: all 0.3s;

  .actions {
    display: flex;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    align-items: center;
    margin-top: 20px;
    height: 50px;
    background-color: #ff6432;
    cursor: pointer;

    i.material-icons {
      line-height: 50px;
    }
  }
}

.open {
  transform: translateY(0%);
  transition: all 1s ease-in-out;
}

.container__categories {
  padding-bottom: 70px; // Heigh of actions  + 20 px
  .mdl-chip {
    margin: 8px;
    cursor: pointer;
    border-radius: 4px;
    background: transparent;
    border: 1px solid white;
    color: white;
  }
  .mdl-chip__text {
    font-size: 15px;
  }
}

.pressed {
  background-color: #2a2a2e !important;
  border: 1px solid #2a2a2e !important;
}

.loading__container {
  display: flex;
  align-items: center;
  justify-content: center;
}

.full {
  top: 0;
  max-height: none;
  height: auto;
  transition: all 0.3s ease-in-out;
}

.actions > span {
  flex: 1;
  text-align: center;
  align-items: center;
  height: 100%;
  &:hover {
    background: #f15928;
  }
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to
/* .fade-leave-active below version 2.1.8 */

 {
  opacity: 0;
}
</style>
