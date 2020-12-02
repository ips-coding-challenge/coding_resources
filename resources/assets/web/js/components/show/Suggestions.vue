<template>
    <div class="mdl-grid">
        <video-item :type="type" :item="item" v-for="item in suggestions" :key="item.id"></video-item>            
    </div>
</template>

<script>
import VideoItem from "../../components/VideoItem.vue";
export default {
  name: "show-suggestions",
  props: ["type", "suggestions"],
  components: { VideoItem },
  methods: {}
};
</script>
