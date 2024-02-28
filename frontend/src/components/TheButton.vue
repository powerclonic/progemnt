<template>
  <v-btn
    class="the-button"
    :color="color"
    :class="{
      'text-secondary-darken-1': colorful,
      'text-primary': lighter || true
    }"
    variant="flat"
  >
    <slot />
  </v-btn>
</template>

<script setup lang="ts">
import { computed } from "vue";

const props = defineProps({
  colorful: {
    type: Boolean,
    required: false,
    default: false
  },
  lighter: {
    type: Boolean,
    required: false,
    default: false
  }
});

const color = computed(() => {
  if (props.colorful) return "primary";
  if (props.lighter) return "secondary-darken-1";
  return "secondary-darken-2";
});
</script>

<style scoped lang="scss">
.the-button {
    color: rgb(var(--v-theme-primary));

    font-weight: bold;

    &--colorful {
        color: rgb(var(--v-theme-secondary-darken-2));
    }

    &--lighter {
        background-color: rgb(var(--v-theme-secondary-darken-1));
    }
}
</style>

