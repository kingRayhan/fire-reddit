<template>
  <div>
    <div class="flex items-center">
      <img src="~/static/images/snoo-1.png" alt="" />
      <h3 class="text-4xl">Notifications</h3>
    </div>

    <div class="my-4">
      <Button @click="notificationMode('all')"> All ({{ allCount }}) </Button>
      <Button @click="notificationMode('reads')">
        Reads ({{ readsCount }})
      </Button>
      <Button @click="notificationMode('unreads')">
        Unreads ({{ ureadsCount }})
      </Button>
      <Button @click="$store.dispatch('notification/clearAll')"> Clear </Button>
    </div>

    <div v-for="notification in notifications" :key="notification.id">
      <NewCommentNotification :notification="notification" />
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import Echo from "laravel-echo";
import Pusher from "pusher-js";
export default {
  name: "NotificationViewerPage",
  middleware: "authenticated",
  head() {
    return {
      title: `Notifications (${this.ureadsCount})`,
    };
  },
  async asyncData({ store }) {
    await store.dispatch("notification/load");
  },
  computed: mapGetters("notification", [
    "notifications",
    "allCount",
    "readsCount",
    "ureadsCount",
  ]),
  methods: mapActions("notification", ["notificationMode"]),
};
</script>
