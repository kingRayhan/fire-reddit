export default function ({ $echo, $auth, store }) {
  if ($auth.loggedIn) {
    $echo
      .channel(`user-notification.${$auth.user.id}`)
      .notification((newNotification) => {
        console.log(newNotification);
        store.dispatch(
          "errors/showMsg",
          `u/${newNotification.commentedBy} commented on your thread`
        );
        store.commit("notification/UNSHIFT_NEW_NOTIFICATION", newNotification);
      });
  }

  $echo.channel("threads").on("on-new-thread-created", (newThread) => {
    store.dispatch("errors/showMsg", "New thread posted");
    store.commit("threads/PREPEND_THREAD", newThread);
  });
}
