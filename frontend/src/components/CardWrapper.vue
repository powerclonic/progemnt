<template>
  <article class="card-wrapper">
    <v-progress-linear v-if="true" indeterminate color="primary" />
    <div v-bind="attrs">
      <slot />
    </div>
  </article>
</template>
<script>
// use normal <script> to declare options
export default {
  inheritAttrs: false,
};
</script>
<script setup>
import { useAppStore } from "@/store/app";

const attrs = useAttrs();
console.log(attrs);

const store = useAppStore();

defineProps({
  loader: {
    type: Boolean,
    default: false,
  },
});
</script>

<style scoped>
.card-wrapper {
  border-radius: 10px;
  background-color: rgba(var(--v-theme-secondary-darken-2));
  /* overflow: hidden; */
}
</style>
