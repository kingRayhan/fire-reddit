<template>
  <div class="share-modal flex items-center justify-start">
    <div>
      <img src="~static/images/share-modal.jpg" />
    </div>
    <div class="text-gray-700">
      <h2 class="text-3xl">WoooHooo!!</h2>
      <p class="text-xl">You chosse to share this? 🍕</p>
      <input
        class="border-1 border-dashed w-full p-2 mt-2 text-gray-700"
        :value="'http://localhost:3000' + url"
        @click="handleSelectText"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: ["url"],
  methods: {
    handleSelectText(e) {
      e.target.select();
    },
  },
};
</script>
<style lang="scss" scoped>
.share-modal {
  background-color: #bdbeff;
}
</style>
