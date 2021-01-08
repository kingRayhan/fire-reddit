<template>
  <div class="flex mb-2 w-full" :id="'thread-' + thread.slug">
    <!-- voting start -->
    <div class="vote">
      <button
        class="arrow arrow--up-vote"
        :class="{ 'arrow--up-vote--voted': isLiked }"
        @click="upVote"
      ></button>
      <button
        class="arrow arrow--down-vote"
        :class="{ 'arrow--down-vote--voted': isUnliked }"
        @click="downVote"
      ></button>
    </div>
    <!-- voting end -->

    <div class="mb-4 ml-5">
      <nuxt-link
        class="font-bold"
        :to="{ name: 'u-name', params: { name: thread.user.username } }"
      >
        u/{{ thread.user.username }}
      </nuxt-link>
      <span class="text-gray-600 text-sm">
        {{ scoreCount }} point(s) ( {{ thread.time }} )
      </span>
      <p class="text-xl">
        {{ thread.body }}
      </p>

      <div>
        <a
          href="#"
          class="text-sm text-red-600 font-bold mr-2"
          @click.prevent="handleDelete"
          v-if="$auth.loggedIn && thread.user.id === $auth.user.id"
        >
          Delete
        </a>

        <a
          href="#"
          class="text-sm text-gray-600 font-bold mr-2"
          @click.prevent="openReply = !openReply"
        >
          <span v-if="openReply">Close</span>
          <span v-else>Reply</span>
        </a>
      </div>

      <div v-if="openReply">
        <WriteComment @done="openReply = false" :parent="thread" />
      </div>

      <div v-if="thread.comments.length" class="mb-2">
        <Comment
          v-for="comment in thread.comments"
          :key="comment.id"
          :thread="comment"
        />
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["thread"],
  data() {
    return {
      openReply: false,
      scoreCount: 0,
      isLiked: false,
      isUnliked: false,
    };
  },
  mounted() {
    this.scoreCount = this.thread.scores;
    this.isLiked = this.thread.upVotedBy.includes(
      this.$auth.loggedIn && this.$auth.user.id
    );
    this.isUnliked = this.thread.downVotedBy.includes(
      this.$auth.loggedIn && this.$auth.user.id
    );
  },
  components: {
    Comment: () => import("./Comment"),
  },
  methods: {
    async handleDelete() {
      if (!this.$auth.loggedIn) {
        return this.$store.dispatch(
          "errors/showError",
          "You have to login first to vote"
        );
      }

      try {
        await this.$store.dispatch(
          "threads/destroyInsideThread",
          this.thread.slug
        );
      } catch {}
    },
    async upVote() {
      if (!this.$auth.loggedIn) {
        return this.$store.dispatch(
          "errors/showError",
          "You have to login first to vote"
        );
      }

      const { currentScores } = await this.$store.dispatch(
        "threads/upVote",
        this.thread.id
      );

      this.scoreCount = currentScores;

      if (this.isLiked) {
        this.isLiked = false;
      } else {
        this.isLiked = true;
      }

      this.isUnliked = false;
    },
    async downVote() {
      if (!this.$auth.loggedIn) {
        return this.$store.dispatch(
          "errors/showError",
          "You have to login first to vote"
        );
      }

      const { currentScores } = await this.$store.dispatch(
        "threads/downVote",
        this.thread.id
      );

      this.scoreCount = currentScores;

      if (this.isUnliked) {
        this.isUnliked = false;
      } else {
        this.isUnliked = true;
      }

      this.isLiked = false;
    },
  },
};
</script>

<style scoped lang="scss">
.vote {
  border-left: 1px dashed #ddf;
  padding-left: 15px;
}
</style>
