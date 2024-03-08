<template>
  <article class="card-wrapper" :style="{ padding: `${padding}px` }">
    <slot />
  </article>
</template>

<script setup>
defineProps({
  padding: {
    type: String,
    default: "10",
  },
});
</script>

<style scoped lang="scss">
.card-wrapper {
  border-radius: 10px;
  background-color: rgba(var(--v-theme-secondary-darken-2));
}
</style>
