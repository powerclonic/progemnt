<template>
  <router-view />
</template>

<script lang="ts" setup>
import vuetify from "./plugins/vuetify";
import { useFlashStore } from "./store/flash";

const flash = useFlashStore();

const themeColors = vuetify.theme.current.value.colors;

const colors = {
  error: themeColors.error,
  warning: themeColors.warning,
  success: themeColors.success,
  default: themeColors.primary,
};

console.log(colors);

watch(
  () => flash.flash_value,
  () => {
    window.document.documentElement.style.setProperty(
      "--v-flash-color",
      colors[flash.flash_type ?? "default"] + "55",
    );
  },
);
</script>

<style>
:root {
  --v-flash-color: #000;
}

html {
  font-family: "Fredoka", Arial, Helvetica, sans-serif;
}

@keyframes pulse {
  0% {
    box-shadow: 0 0 0 0 transparent;
  }
  70% {
    box-shadow: 0 0 50px 0 var(--v-flash-color);
  }
  100% {
    box-shadow: 0 0 0 0 transparent;
  }
}

.v-snackbar__wrapper {
  overflow: visible !important;
  border: 5px solid var(--v-theme-flash);
  animation: pulse 5s infinite;
}
</style>
