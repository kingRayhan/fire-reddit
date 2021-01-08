<template>
  <div>
    <div v-if="title" class="bg-primaryLight font-bold px-2 py-1 text-gray-700">
      {{ title }}
    </div>
    <div
      class="border p-2"
      :class="{
        'border-t-0': title,
      }"
    >
      <slot />
    </div>
  </div>
</template>
<script>
export default {
  props: ['title'],
}
</script>
