<template>
  <router-view />
</template>

<script lang="ts" setup>
//
</script>

<style>
html {
  font-family: "Fredoka", Arial, Helvetica, sans-serif;
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 rgba(var(--v-theme-primary), 0);
  }
  70% {
    box-shadow: 0 0 50px 20px rgba(var(--v-theme-primary), 0.4);
  }
  100% {
    box-shadow: 0 0 0 0 rgba(var(--v-theme-primary), 0);
  }
}

.v-snackbar__wrapper {
  overflow: visible !important;

  animation: pulse 5s infinite;
}
</style>
