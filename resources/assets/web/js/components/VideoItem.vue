<template>
  <div class="mdl-card mdl-shadow--2dp mdl-cell mdl-cell--4-col mdl-cell--12-col-phone card_video">
    <div
      class="item-type"
      :class="searchType"
      v-if="forSearch"
    >{{ forSearchType }}</div>
    <a
      :href="url"
      class="content_container"
    >
      <div
        class="card_img"
        v-lazy:background-image="itemCover()"
      >
        <span class="card_duration">{{ handleType }}</span>
        <img
          class="card_language"
          :src="itemLang()"
          alt="language"
        />
      </div>
      <div class="card_text">
        <div class="card_title">{{ title }}</div>
        <div class="card_channel">{{ item.channel_name }}</div>
      </div>
    </a>

    <div class="mdl-card__actions mdl-card--border">
      <div class="mdl-card__actions">
        <span
          class="mdl-chip"
          v-for="cat in item.categories"
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
  name: "video-item",
  props: ["type", "item", "forSearch"],
  computed: {
    handleType() {
      if (this.type == "conference") {
        return this.item.duration;
      } else if (this.type == "tuto") {
        const parts = this.item.tuto_parts.length + 1; // Pas oublier de rajouter la premiere partie
        if (parts > 1) {
          return parts + " parts";
        } else {
          return 1 + " part";
        }
      }
    },
    title() {
      return shorter(this.item.title, 60);
    },
    url() {
      return "/" + this.type + "/" + this.item.slug;
    },
    forSearchType() {
      if (this.type === "conference") {
        return "Conference";
      } else if (this.type === "tuto") {
        return "Tuto";
      }
    },
    searchType() {
      if (this.type === "conference") {
        return "conference-type";
      } else if (this.type === "tuto") {
        return "tuto-type";
      }
    },
    postedOn() {
      return moment(this.item.created_at).format("MMM DD, YYYY");
    }
  },
  methods: {
    itemCover() {
      return `https://img.youtube.com/vi/${this.item.youtube_id}/mqdefault.jpg`;
    },
    itemLang() {
      if (this.item.langue_id == 1) {
        return publicPath + "/img/uk.jpg";
      } else {
        return publicPath + "/img/france.jpg";
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.card_video {
  min-height: 120px;
  margin: 8px 8px 24px 8px;
  cursor: pointer;
  transition: 0.3s;
  &:hover {
    transition: 0.3s;
    background-color: #eeeeee;
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
  min-height: 120px;
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
}

.card_title {
  color: rgba(0, 0, 0, 0.54);
  font-size: 15px;
  font-weight: 700;
}

.card_channel {
  color: #ff5722;
  font-size: 0.9em;
  margin-top: 12px;
}

.card_date {
  font-size: 0.9rem;
  margin-top: 12px;
  color: #777777;
  text-align: right;
}

@media (max-width: 800px) {
  .card_video:last-child {
    margin-bottom: 0;
  }
}

@media (max-width: 839px) and (min-width: 480px) and (orientation: landscape) {
  .card_img {
    flex-basis: 60%;
  }
}
</style>

