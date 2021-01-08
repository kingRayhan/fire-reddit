<template>
  <div>
    <div class="rounded" :class="{ 'bg-gray-200': expanded }">
      <!-- Vote start -->
      <div class="thread flex items-center mb-4">
        <div class="mr-5 flex flex-col items-center">
          <button
            class="arrow arrow--up-vote"
            :class="{ 'arrow--up-vote--voted': isLiked }"
            @click="upVote"
          ></button>
          <div class="text-gray-600 font-bold text-sm">{{ scoreCount }}</div>
          <button
            class="arrow arrow--down-vote"
            :class="{
              'arrow--down-vote--voted': isUnliked,
            }"
            @click="downVote"
          ></button>
        </div>
        <!-- Vote end -->

        <!-- Thread Type start -->
        <div class="mr-4">
          <nuxt-link
            :to="{ name: 'threads-slug', params: { slug: thread.slug } }"
            class="logos block"
            :class="{
              'logos--logo-link': thread.is_link,
              'logos--logo-post': !thread.is_link,
            }"
          ></nuxt-link>
        </div>
        <!-- Thread Type end -->

        <div>
          <nuxt-link
            class="text-xl mt-0"
            :to="{ name: 'threads-slug', params: { slug: thread.slug } }"
          >
            {{ thread.title }}
          </nuxt-link>
          <a
            v-if="thread.is_link"
            :href="thread.link"
            target="_blank"
            class="text-gray-500 text-sm"
          >
            ({{ thread.link }})
          </a>

          <div class="flex">
            <button
              class="icons icons--icon-post mr-2"
              v-if="thread.thumbnail"
              @click="expanded = !expanded"
            ></button>

            <div>
              <p class="text-gray-600 text-sm">
                submitted {{ thread.time }} by
                <nuxt-link
                  :to="{
                    name: 'u-name',
                    params: { name: thread.user.username },
                  }"
                  class="font-bold text-gray-600"
                >
                  u/{{ thread.user.username }}
                </nuxt-link>
              </p>

              <div>
                <span class="text-sm font-bold text-gray-600 mr-3">
                  {{ thread.comments_count }} comments
                </span>
                <button
                  @click="showShareModal = true"
                  class="text-sm font-bold text-gray-600 mr-3 hover:underline"
                >
                  Share
                </button>
                <a
                  @click.prevent="handleDelete"
                  v-if="$auth.loggedIn && $auth.user.id == thread.user.id"
                  class="text-sm font-bold text-gray-600 text-red-600 cursor-pointer"
                >
                  Delete
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-if="expanded && thread.thumbnail">
        <img :src="thread.thumbnail" :alt="thread.title" />
      </div>
    </div>
    <Modal v-model="showShareModal" :width="650">
      <ShareModal :url="`/threads/${thread.slug}`" />
    </Modal>
  </div>
</template>

<script>
import { mapActions } from "vuex";
export default {
  props: {
    thread: {
      type: Object,
    },
    expanded: {
      type: Boolean,
      default: false,
    },
  },
  mounted() {
    this.scoreCount = this.thread.scores;
    this.isLiked = this.thread.upVotedBy.includes(
      this.$auth.loggedIn && this.$auth.user.id
    );
    this.isUnliked = this.thread.downVotedBy.includes(
      this.$auth.loggedIn && this.$auth.user.id
    );

    this.$echo
      .channel(`thread-vote-count.${this.thread.id}`)
      .on("on-vote-updated", ({ count }) => {
        this.scoreCount = count;
      });
  },
  data() {
    return {
      scoreCount: 0,
      isLiked: false,
      isUnliked: false,
      showShareModal: false,
    };
  },
  methods: {
    async upVote() {
      if (!this.$auth.loggedIn) {
        return this.$store.dispatch(
          "errors/showError",
          "You have to login first to vote"
        );
      }
      try {
        const { currentScores } = await this.$store.dispatch(
          "threads/upVote",
          this.thread.id
        );
        this.scoreCount = currentScores;
      } catch {}

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
      try {
        const { currentScores } = await this.$store.dispatch(
          "threads/downVote",
          this.thread.id
        );
        this.scoreCount = currentScores;
      } catch {}

      if (this.isUnliked) {
        this.isUnliked = false;
      } else {
        this.isUnliked = true;
      }

      this.isLiked = false;
    },
    async handleDelete() {
      try {
        await this.$store.dispatch("threads/destroy", this.thread.slug);
        this.$emit("deleted");
      } catch {}
    },
  },
};
</script>
