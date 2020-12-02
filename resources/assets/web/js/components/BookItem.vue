<template>

  <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--12-col-phone card_book">
    <div
      class="item-type book-type"
      v-if="forSearch"
    >Book</div>
    <a
      :href="book.link"
      target="_blank"
      rel="noopener noreferrer"
    >
      <div class="content_container">
        <div
          class="card_img"
          v-lazy:background-image="book.cover"
        ></div>

        <div class="card_text">
          <div class="card_title">{{ title }}</div>
          <div class="card_author">{{ book.author }}</div>
        </div>

      </div>

      <div class="mdl-card__supporting-text">{{ description }}</div>

      <div class="mdl-card__actions">
        <span
          class="mdl-chip"
          v-for="cat in book.categories"
          :key="cat.id"
        >
          <span class="mdl-chip__text">{{ cat.name }}</span>
        </span>
      </div>

    </a>
  </div>

</template>

<script>
import { shorter } from "../utility.js";

export default {
  name: "book-item",
  props: ["book", "forSearch"],
  computed: {
    title() {
      return shorter(this.book.title, 60);
    },
    url() {
      return shorter(this.book.link, 60);
    },
    description() {
      return shorter(this.book.description, 150);
    }
  },
  methods: {}
};
</script>

<style lang="scss" scoped>
.card_book {
  min-height: 100px;
  margin: 8px 8px 24px 8px;
  cursor: pointer;
  // background-color: #EEEEEE;
  transition: 0.3s;
  &:hover {
    transition: 0.3s;
    background-color: #dddddd;
  }

  a {
    color: inherit;
    text-decoration: inherit;
  }

  .mdl-chip {
    margin-right: 4px;
    height: 24px;
    line-height: 24px;
    background-color: inherit;
    border: 1px solid gray;
    border-radius: 4px;
  }

  .mdl-cell {
    margin: 20px auto;
  }
}

.content_container {
  display: flex;
  padding: 8px;
  min-height: 100px;
  flex-wrap: nowrap;
  flex-direction: row;
  justify-content: flex-start;
  align-items: stretch;
}

.card_img {
  position: relative;
  order: 1;
  flex-basis: 70%;
  height: 150px;
  border-radius: 4px;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

.card_text {
  order: 2;
  flex-basis: 100%;
  margin-left: 8px;
  text-align: center;
  font-weight: 500;
}

.card_title {
  font-size: 15px;
  font-weight: 700;
}

.card_author {
  color: #ff5722;
  font-size: 0.9em;
  margin-top: 12px;
}

@media (max-width: 800px) {
  .card_book:last-child {
    margin-bottom: 0;
  }
}

@media (max-width: 839px) and (min-width: 480px) and (orientation: landscape) {
  .card_img {
    flex-basis: 60%;
  }
}
</style>

