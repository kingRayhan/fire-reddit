import url from "url";

export const state = () => ({
  index: [],
  meta: {},
});

export const mutations = {
  /**
   * Threads
   */
  SET_THREADS: (state, threads) => {
    state.index = threads;
  },
  APPEND_THREADS: (state, threads) => {
    state.index = [...state.index, ...threads];
  },
  PREPEND_THREAD: (state, thread) => {
    state.index = [thread, ...state.index];
  },
  SET_META: (state, links) => {
    state.meta = {
      next: links.next && parseInt(url.parse(links.next, true).query.page),
      prev: links.prev && parseInt(url.parse(links.prev, true).query.page),
    };
  },
};

export const actions = {
  async register(ctx, payload) {
    await this.$axios.$post("auth/register", payload);
    this.$router.push("/auth/login");
    this.$modal.show({
      type: "success",
      title: "You have been register successfully",
    });
  },
  async updateProfile(_, payload) {
    return await this.$axios.$post("auth/update-profile", payload);
  },
  async updatePassword(_, payload) {
    return await this.$axios.$post("auth/password/update", payload);
  },
  async destroyProfile(_, payload) {
    this.$modal.show({
      type: "danger",
      title: "Sure to delete your account?",
      body:
        "Be careful. Once you delete your profile, it can not be undone. All post/link/comment your created will deleted autometically.",
      primary: {
        label: "Destroy my profile",
        theme: "red",
        action: async () => {
          await this.$axios.$post("auth/delete", payload);
          await this.$auth.logout();
        },
      },
    });
  },

  async resendVarificationEmail() {
    return await this.$axios.$post("auth/resend-verification-email");
  },

  /**
   * -----------------------------------------------
   * Threads
   * -----------------------------------------------
   */
  async load({ commit }, username) {
    const { data, links } = await this.$axios.$get(`threads/user/${username}`);
    commit("SET_THREADS", data);
    commit("SET_META", links);
  },

  async nextThreads({ state, commit }, username) {
    const { data, links } = await this.$axios.$get(
      `threads/user/${username}?page=${state.meta.next}`
    );
    commit("APPEND_THREADS", data);
    commit("SET_META", links);
  },
};
