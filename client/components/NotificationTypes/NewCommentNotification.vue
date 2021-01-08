<template>
  <div
    class="p-2 mb-2"
    :class="{
      'bg-gray-100': notification.read_at,
      'bg-primaryLight': !notification.read_at,
    }"
  >
    <div>
      <nuxt-link
        :to="{
          name: 'u-name',
          params: { name: notification.commentedBy },
        }"
      >
        u/{{ notification.commentedBy }}
      </nuxt-link>
      commented on your post:
      <nuxt-link :to="`/threads/${notification.slug}`">{{
        notification.body
      }}</nuxt-link>
    </div>
    <div>
      <button
        v-if="notification.read_at"
        class="text-xs font-bold mr-2"
        @click="markAsUnread(notification.id)"
      >
        Mark as unread
      </button>
      <button
        v-if="!notification.read_at"
        class="text-xs font-bold mr-2"
        @click="markAsRead(notification.id)"
      >
        Mark as read
      </button>
      <button
        class="text-xs text-red-500 font-bold"
        @click="destroy(notification.id)"
      >
        Delete
      </button>
    </div>
  </div>
</template>
<script>
import { mapActions } from "vuex";
export default {
  props: ["notification"],
  methods: {
    ...mapActions("notification", ["markAsRead", "markAsUnread", "destroy"]),
  },
};
</script>
