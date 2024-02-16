<template>
  <v-btn
    class="the-button"
    :class="{
      'the-button--colorful': colorful,
      'the-button--lighter': lighter,
    }"
  >
    <slot />
  </v-btn>
</template>

<script setup lang="ts">
defineProps({
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
})
</script>

<style scoped lang="scss">
.the-button {
    background-color: rgb(var(--v-theme-secondary-darken-2));
    color: rgb(var(--v-theme-primary));

    font-weight: bold;

    &--colorful {
        background-color: rgb(var(--v-theme-primary));
        color: rgb(var(--v-theme-secondary-darken-2));
    }

    &--lighter {
        background-color: rgb(var(--v-theme-secondary-darken-1));
    }
}
</style>

