export const actions = {
  async nuxtServerInit({ dispatch }) {
    // Load all threads
    await dispatch("threads/load");

    // Load user notifications
    if (this.$auth.loggedIn) {
      await dispatch("notification/load");
    }
  },
};
