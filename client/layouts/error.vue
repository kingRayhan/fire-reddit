<template>
  <div class="text-center my-12">
    <div>
      <img class="mx-auto" src="~/static/images/404.png" alt="" />
    </div>
    <div>
      <h2 class="text-3xl">{{ message }}</h2>
      <p class="text-lg">The page you requested does not exist</p>
    </div>
  </div>
</template>
<script>
export default {
  name: "RedditErrorPage",
  layout: "fullWidth",
  props: {
    error: {
      type: Object,
      default: null,
    },
  },
  computed: {
    statusCode() {
      return (this.error && this.error.statusCode) || 500;
    },
    message() {
      return this.error.message || "<%= messages.client_error %>";
    },
  },
  head() {
    return {
      title: this.message,
      meta: [
        {
          name: "viewport",
          content: "width=device-width,initial-scale=1.0,minimum-scale=1.0",
        },
      ],
    };
  },
};
</script>
