import url from "url";

export const state = () => ({
  index: [],
  show: null,
  meta: {},
});

export const mutations = {
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
  SET_SHOW: (state, payload) => (state.show = payload),
};

export const actions = {
  async load({ commit }) {
    const { data, links } = await this.$axios.$get("threads");
    commit("SET_THREADS", data);
    commit("SET_META", links);
  },

  async nextThreads({ state, commit }) {
    const { data, links } = await this.$axios.$get(
      `threads?page=${state.meta.next}`
    );
    commit("APPEND_THREADS", data);
    commit("SET_META", links);
  },

  async show({ commit }, slug) {
    const thread = await this.$axios.$get(`threads/${slug}`);
    commit("SET_SHOW", thread.data);
  },

  async store({ commit }, payload) {
    const { data } = await this.$axios.$post("threads", payload);
    this.$router.push({ name: "threads-slug", params: { slug: data.slug } });
    commit("PREPEND_THREAD", data);
  },

  async storeComment({ dispatch, state }, { parentSlug, body }) {
    await this.$axios.$post(`threads/${parentSlug}/comment`, {
      body,
    });
    await dispatch("show", state.show.slug);
  },

  async destroy({ commit, state }, slug) {
    await this.$axios.$delete(`threads/${slug}`);
    commit(
      "SET_THREADS",
      state.index.filter((thread) => thread.slug !== slug)
    );
  },

  async destroyInsideThread({ dispatch, state }, slug) {
    await this.$axios.$delete(`threads/${slug}`);
    await dispatch("show", state.show.slug);
  },

  upVote(_, thread_id) {
    return this.$axios.$post(`vote/${thread_id}/upvote`);
  },
  downVote(_, thread_id) {
    return this.$axios.$post(`vote/${thread_id}/downvote`);
  },
};
