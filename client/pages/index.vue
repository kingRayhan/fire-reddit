<template>
  <main>
    <div class="mb-4">
      <WelcomeBanner />
    </div>
    <Thread v-for="thread in index" :key="thread.id" :thread="thread" />

    <div class="my-8">
      <InfiniteScroller spinner="spiral" @infinite="infiniteScroll" />
    </div>
  </main>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  name: "HomePage",

  head: {
    title: "Reddit | Home",
  },
  computed: {
    ...mapState("threads", ["index", "meta"]),
  },
  methods: {
    async infiniteScroll($state) {
      if (!this.meta.next) {
        return $state.complete();
      }
      await this.$store.dispatch("threads/nextThreads");
      $state.loaded();
    },
  },
};
</script>
