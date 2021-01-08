export const state = () => ({
  message: null,
  errors: {},
});

export const getters = {
  hasErrors: (state) =>
    state.message !== undefined || Object.keys(state.errors).length > 0,
};

export const mutations = {
  SET_UNCONTROLLED_ERROR: (state, msg) => (state.message = msg),
  SET_VALIDATION_ERRORS: (state, errors) => (state.errors = errors),
  CLEAR: (state) => {
    state.message = null;
    state.errors = {};
  },
};

export const actions = {
  throwError({ commit }, message) {
    commit("SET_UNCONTROLLED_ERROR", message);
  },
  catchServerError({ commit }, payload) {
    const errorResponse = payload.response.data;

    if (errorResponse.message) {
      commit("SET_UNCONTROLLED_ERROR", errorResponse.message);
      this.$toast.show({
        title: errorResponse.message,
        message: "",
        classToast: "bg-red-600",
        classTitle: "text-red-100",
        classMessage: "text-red-200",
        classClose: "text-red-300",
        classTimeout: "bg-red-800",
      });
    }

    if (errorResponse.errors) {
      const allErrors = {};
      for (const key in errorResponse.errors) {
        allErrors[key] = errorResponse.errors[key][0];
      }
      commit("SET_VALIDATION_ERRORS", allErrors);
    }
  },

  showError(_, msg) {
    this.$toast.show({
      title: msg,
      message: "",
      classToast: "bg-red-600",
      classTitle: "text-red-100",
      classMessage: "text-red-200",
      classClose: "text-red-300",
      classTimeout: "bg-red-800",
    });
  },

  showMsg(_, title) {
    this.$toast.show({
      title,
      message: "",
      classToast: "bg-green-500",
      classTitle: "text-white",
      classClose: "text-white",
      classTimeout: "bg-primaryDark",
    });
  },
};
