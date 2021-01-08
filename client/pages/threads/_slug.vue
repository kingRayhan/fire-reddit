<template>
  <main>
    <Thread
      @deleted="$router.push({ name: 'index' })"
      :thread="thread"
      :expanded="true"
    />

    <hr class="my-5" />

    <div
      class="text-2xl border border-dashed p-2 rounded my-4"
      v-if="thread.body"
    >
      {{ thread.body }}
    </div>

    <WriteComment :parent="thread" />

    <Comment
      v-for="comment in thread.comments"
      :thread="comment"
      :key="comment.id"
    />
  </main>
</template>
<script>
import { mapState, mapActions } from "vuex";
export default {
  name: "ThreadDetails",
  computed: { ...mapState({ thread: (state) => state.threads.show }) },
  async asyncData({ store, params, error }) {
    try {
      await store.dispatch("threads/show", params.slug);
    } catch (e) {
      error({ statusCode: 404, message: "This thread is not found" });
    }
  },
  head() {
    return {
      title: `Fire Reddit | ${this.thread.title}`,
    };
  },
};
</script>
