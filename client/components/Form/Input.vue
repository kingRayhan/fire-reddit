<template>
  <div class="input-component mb-2">
    <label>
      <span v-if="label" class="font-bold text-gray-600">
        {{ label }}
      </span>

      <input
        v-bind="$attrs"
        :name="name"
        class="border block px-2 py-1 focus:outline-none w-full text-xl"
        :class="{ 'border-red-500': errorMsg }"
        :value="value"
        @input="$emit('input', $event.target.value)"
      />
      <p v-if="errorMsg" class="text-red-500">{{ errorMsg }}</p>
    </label>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  props: {
    value: { required: false, default: "" },
    label: { type: String, default: "Text input label" },
    name: { type: String, required: true },
  },
  computed: {
    ...mapState({
      errors: (state) => state.errors.errors,
    }),
    errorMsg() {
      return this.errors[this.name];
    },
  },
};
</script>
