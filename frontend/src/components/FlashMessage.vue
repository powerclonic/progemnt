<template>
  <v-snackbar
    v-model="store.flash_value"
    timeout="10000"
    class="snackbar"
    absolute
    location="bottom start"
    :transition="VSlideXTransition"
  >
    <div
      class="snackbar__content"
      :class="`snackbar__content--${store.flash_type}`"
    >
      <v-icon :icon="store.flash_icon" class="snackbar__icon" />
      <p class="snackbar__text">
        {{ store.flash_message }}
      </p>
    </div>
  </v-snackbar>
</template>

<script setup lang="ts">
import { useFlashStore } from "@/store/flash";
import { VSlideXTransition } from "vuetify/lib/components/index.mjs";

const store = useFlashStore();
</script>

<style scoped lang="scss">
.snackbar {
  &__content {
    display: flex;
    align-items: center;
    gap: 10px;

    border-left: 4px solid;
    height: 100%;

    &--success {
      border-color: rgb(var(--v-theme-success));
    }

    &--warning {
      border-color: rgb(var(--v-theme-warning));
    }

    &--error {
      border-color: rgb(var(--v-theme-error));
    }
  }

  &__icon {
    font-size: 1.75rem;
  }

  &__text {
    font-size: 1.25rem;
  }
}
</style>
