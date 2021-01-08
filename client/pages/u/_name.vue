<template>
  <div>
    <div class="border-2 border-dashed px-2">
      <h1 class="text-3xl uppercase">u/{{ $route.params.name }}</h1>
    </div>
    <Thread v-for="thread in index" :key="thread.id" :thread="thread" />

    <div class="my-8">
      <InfiniteScroller spinner="spiral" @infinite="infiniteScroll" />
    </div>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  name: "UserProfile",
  computed: {
    ...mapState("user", ["index", "meta"]),
  },
  async asyncData({ store, params }) {
    await store.dispatch("user/load", params.name);
  },
  methods: {
    async infiniteScroll($state) {
      if (!this.meta.next) {
        return $state.complete();
      }
      await this.$store.dispatch("user/nextThreads", this.$route.params.name);
      $state.loaded();
    },
  },
};
</script>
