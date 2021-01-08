export const state = () => ({
  all: [],
  unreads: [],
  reads: [],
  mode: "all", // all , unreads, reads
});

export const mutations = {
  SET_ALL: (state, payload) => (state.all = payload),
  SET_UNREADS: (state, payload) => (state.unreads = payload),
  SET_READS: (state, payload) => (state.reads = payload),
  SET_MODE: (state, payload) => (state.mode = payload),
  UNSHIFT_NEW_NOTIFICATION: (state, payload) => {
    state.unreads.unshift(payload);
    state.all.unshift(payload);
  },
};

export const getters = {
  notifications: (state) => {
    return state[state.mode];
  },
  allCount: (state) => state.all.length,
  readsCount: (state) => state.reads.length,
  ureadsCount: (state) => state.unreads.length,
};

export const actions = {
  async load({ commit }) {
    const all = await this.$axios.$get("notifications");
    const reads = await this.$axios.$get("notifications/reads");
    const unreads = await this.$axios.$get("notifications/unreads");

    const notificationResource = (notifications) => {
      return notifications.map((notification) => ({
        type: notification.type,
        id: notification.id,
        ...notification.data,
      }));
    };

    commit("SET_ALL", notificationResource(all));
    commit("SET_READS", notificationResource(reads));
    commit("SET_UNREADS", notificationResource(unreads));
  },
  notificationMode({ commit }, mode) {
    commit("SET_MODE", mode);
  },
  async markAsRead({ dispatch }, id) {
    await this.$axios.$post(`notifications/mark-as-read/${id}`);
    await dispatch("load");
  },
  async markAsUnread({ dispatch }, id) {
    await this.$axios.$post(`notifications/mark-as-unread/${id}`);
    await dispatch("load");
  },
  async destroy({ dispatch }, id) {
    await this.$axios.$delete(`notifications/delete/${id}`);
    await dispatch("load");
  },
  async clearAll({ dispatch }, id) {
    await this.$axios.$delete(`notifications/destroy-all`);
    await dispatch("load");
  },
};
