export default ({ $axios, store, error }) => {
  $axios.onError(function (error) {
    store.dispatch("errors/catchServerError", error);
  });

  $axios.onRequest(function () {
    store.commit("errors/CLEAR");
  });
};
