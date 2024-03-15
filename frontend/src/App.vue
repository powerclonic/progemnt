<template>
  <router-view />
</template>

<script lang="ts" setup>
//
</script>

<style lang="scss">
html {
  font-family: "Fredoka", Arial, Helvetica, sans-serif;
}

* {
  & {
    scrollbar-width: thin;
    scrollbar-color: rgb(var(--v-theme-secondary))
      rgb(var(--v-theme-secondary-darken-2));
  }

  &::-webkit-scrollbar {
    height: 6px;
    margin-top: 12px;
  }

  &::-webkit-scrollbar-track {
    background: rgb(var(--v-theme-secondary-darken-2));
  }

  &::-webkit-scrollbar-thumb {
    background-color: rgb(var(--v-theme-secondary));
    border-radius: 10px;
  }
}
</style>
