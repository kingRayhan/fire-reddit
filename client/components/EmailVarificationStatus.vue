<template>
  <div v-if="$auth.loggedIn">
    <div
      v-if="!$auth.user.email_verified_at"
      class="text-center p-2 bg-primaryLight"
    >
      <img
        class="mx-auto"
        src="~/static/images/snoo-verify0email.png"
        alt="verify-email"
      />
      <h2 class="text-2xl mb-2">
        You can not submit new post/link before verifying email
      </h2>

      <Button @click="handleResend" :disabled="loading">
        <span v-if="loading">Wait...</span>
        <span v-else>Resend Mail</span>
      </Button>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      loading: false,
    };
  },
  methods: {
    async handleResend() {
      this.loading = true;
      try {
        const { message } = await this.$store.dispatch(
          "user/resendVarificationEmail"
        );
        this.loading = false;
        await this.$store.dispatch("errors/showToastr", message);
        this.$store.dispatch("errors/showMsg", "Varification mail sent again");
      } catch {
        this.loading = false;
      }
    },
  },
};
</script>
