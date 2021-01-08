<template>
  <div>
    <div
      v-if="!$auth.loggedIn"
      class="text-center border border-dashed py-8 my-3 bg-primaryLight"
    >
      <h3 class="text-2xl uppercase mb-2">Login to start discussion</h3>
      <Button @click="showLogin = true">Login Now</Button>
    </div>
    <div class="mb-5" v-else>
      <div class="mb-3">
        <Textarea placeholder="Comment" name="body" v-model="commentText" />
      </div>
      <Button @click="createComment">Comment</Button>
    </div>

    <Modal v-model="showLogin" :width="400">
      <Login :card="false" />
    </Modal>
  </div>
</template>

<script>
import { mapState, mapActions } from "vuex";
export default {
  props: ["parent"],
  data() {
    return {
      commentText: "",
      showLogin: false,
    };
  },
  methods: {
    async createComment() {
      try {
        await this.$store.dispatch("threads/storeComment", {
          body: this.commentText,
          parentSlug: this.parent.slug,
        });
        this.commentText = "";
        this.$emit("done");
      } catch {}
    },
  },
};
</script>
