<template>
  <article class="card-wrapper">
    <slot />
  </article>
</template>

<style scoped>
.card-wrapper {
    border-radius: 10px;
    background-color: rgba(var(--v-theme-secondary-darken-2));
}
</style>