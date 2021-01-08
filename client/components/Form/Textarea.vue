<template>
  <div>
    <span v-if="label">
      {{ label }}
    </span>

    <textarea
      :name="name"
      v-bind="$attrs"
      :class="{ 'border-red-500': errorMsg }"
      :value="value"
      @input="$emit('input', $event.target.value)"
      rows="2"
    />

    <p v-if="errorMsg" class="text-red-500">{{ errorMsg }}</p>
  </div>
</template>

<script>
import { mapState } from 'vuex'
export default {
  props: {
    value: { required: false, default: '' },
    label: { type: String },
    name: { type: String, required: true },
  },
  computed: {
    ...mapState({
      errors: (state) => state.errors.errors,
    }),
    errorMsg() {
      return this.errors[this.name]
    },
  },
}
</script>

<style scoped lang="scss">
label {
  @apply font-bold text-gray-600;
}
textarea {
  @apply border block px-2 py-1 w-full text-xl;
  &:focus {
    @apply outline-none;
  }
}
</style>
