<template>
  <div class="welcome-banner">
    <h2 class="text-2xl">Welcome to Reddit.</h2>
    <h4 class="text-xl mb-2">
      Where a community about your favorite things is waiting for you.
    </h4>
    <Button v-if="!$auth.loggedIn" @click="gotoRegister">
      Become a Redditor
    </Button>
    <Button v-if="$auth.loggedIn" @click="gotoNewThread"> Create post </Button>
  </div>
</template>

<script>
export default {
  methods: {
    gotoRegister() {
      this.$router.push({ name: "auth-register" });
    },
    gotoNewThread() {
      this.$router.push({ name: "new" });
    },
  },
};
</script>

<style scoped>
.welcome-banner {
  background-image: url("~static/images/welcome-banner.png");
  background-position: right;
  background-color: #fefbca;
  padding: 8px;
}
</style>
