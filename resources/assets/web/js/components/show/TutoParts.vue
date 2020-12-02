<template>
  <div
    class="parts__container"
    v-if="tutoParts.length > 1"
  >
    <table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
      <thead>
        <tr>
          <th class="mdl-data-table__cell--non-numeric">Part</th>
          <th class="mdl-data-table__cell--non-numeric">Title</th>
          <th>Duration</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(part, i) in tutoParts"
          :key="part.id"
          @click="selectPart(part)"
          :class="{'is-selected' : isSelected(part.part_number) }"
        >
          <td class="mdl-data-table__cell--non-numeric">{{ i + 1 }}</td>
          <td class="mdl-data-table__cell--non-numeric">{{ part.title }}</td>
          <td>{{ part.duration }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "tuto-parts",
  props: ["item"],
  data() {
    return {
      tutoParts: this.item.tuto_parts,
      selectedPart: 1
    };
  },
  mounted() {
    this.addFirstPart();
  },
  methods: {
    addFirstPart() {
      const firstPart = {
        id: this.item.id,
        title: this.item.title,
        part_number: 1,
        duration: this.item.duration,
        youtube_id: this.item.youtube_id
      };

      this.tutoParts.unshift(firstPart);
    },
    selectPart(part) {
      console.log("Select part called");
      this.selectedPart = part.part_number;
      const player = document.querySelector("#youtubePlayer");
      const layout = document.querySelector(".mdl-layout__content");
      player.src = "https://www.youtube.com/embed/" + part.youtube_id;
      setTimeout(() => {
        window.scrollTo(0, 0);
      }, 200);
    },
    isSelected(partNumber) {
      return partNumber === this.selectedPart;
    }
  }
};
</script>
<style lang="scss" scoped>
.parts__container {
  overflow-x: auto;
}
table {
  width: 100%;
  margin-top: 20px;
}
tbody > tr {
  cursor: pointer;
}
.is-selected {
  background-color: #ccc;
}
</style>
