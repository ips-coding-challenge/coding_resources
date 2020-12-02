<template>

  <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--12-col-phone card_article">
    <div
      class="item-type article-type"
      v-if="forSearch"
    >Article</div>
    <a
      :href="article.url"
      target="_blank"
      rel="noopener noreferrer"
      class="content_container"
    >

      <div class="mdl-card__supporting-text">

        <div class="card_title">{{ title }}</div>
        <div class="card_channel">{{ url }}</div>

      </div>

    </a>
    <div class="mdl-card__actions mdl-card--border">
      <div class="mdl-card__actions">

        <span
          class="mdl-chip"
          v-for="cat in article.categories"
          :key="cat.id"
        >
          <span class="mdl-chip__text">{{ cat.name }}</span>
        </span>
        <div class="card_date"><em>Posted on {{ postedOn }}</em></div>
      </div>
    </div>

  </div>

</template>

<script>
import { shorter } from "../utility.js";
import moment from "moment";

export default {
  name: "article-item",
  props: ["article", "forSearch"],
  computed: {
    title() {
      return shorter(this.article.title, 60);
    },
    url() {
      return shorter(this.article.url, 60);
    },
    postedOn() {
      return moment(this.article.created_at).format("MMM DD, YYYY");
    }
  },
  methods: {}
};
</script>

<style lang="scss" scoped>
.card_article {
  min-height: 100px;
  margin: 8px 8px 24px 8px;
  cursor: pointer;
  // background-color: #eeeeee;
  transition: 0.3s;
  &:hover {
    transition: 0.3s;
    background-color: #dddddd;
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
  color: inherit;
  text-decoration: inherit;
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
  flex-basis: 100%;
  border-radius: 4px;
  height: 100px;
  background-repeat: no-repeat;
  background-position: center;
  background-size: cover;
}

.card_duration {
  background: purple;
  color: white;
  position: absolute;
  border-radius: 4px;
  font-size: 0.8em;
  padding: 2px 4px;
  bottom: 4px;
  right: 4px;
}

.card_language {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  position: absolute;
  top: 4px;
  left: 4px;
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
  text-align: center;
}

.card_channel {
  color: #ff5722;
  font-size: 1em;
  margin-top: 12px;
  text-align: center;
}

.card_date {
  font-size: 0.9rem;
  margin-top: 12px;
  color: #777777;
  text-align: right;
}

@media (max-width: 800px) {
  .card_article:last-child {
    margin-bottom: 0;
  }
}

@media (max-width: 839px) and (min-width: 480px) and (orientation: landscape) {
  .card_img {
    flex-basis: 60%;
  }
}
</style>

