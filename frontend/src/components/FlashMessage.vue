<template>
  <v-snackbar
    v-model="store.flash_value"
    timeout="10000"
    class="snackbar"
    absolute
  >
    <div class="snackbar__content">
      <div
        class="snackbar__icon"
        :class="`snackbar__icon--${store.flash_type}`"
      >
        <v-icon :icon="store.flash_icon" />
      </div>
      <p class="snackbar__text">
        {{ store.flash_message }}
      </p>
    </div>
  </v-snackbar>
</template>

<script setup lang="ts">
import { useFlashStore } from "@/store/flash";

const store = useFlashStore();
</script>

<style scoped lang="scss">
.v-overlay__content,
.v-snackbar__wrapper,
.v-snackbar--variant-text {
  overflow: visible;
}

.snackbar {
  align-items: unset;
  box-shadow: unset;
  overflow: unset;

  &__content {
    display: grid;
    grid-template-columns: auto 1fr;

    gap: 10px;
    height: 100%;

    background-color: rgb(var(--v-theme-secondary-darken-2));
    color: #fff;

    border-radius: 4px;

    overflow: hidden;
  }

  &__icon {
    aspect-ratio: 1/1;
    font-size: 1.25rem;

    padding: 0.75rem;

    &--success {
      background-color: rgb(var(--v-theme-success));
    }

    &--warning {
      background-color: rgb(var(--v-theme-warning));
    }

    &--error {
      background-color: rgb(var(--v-theme-error));
    }
  }

  &__text {
    display: flex;
    align-items: center;

    font-size: 1.2rem;
    padding-right: 10px;
  }
}
</style>
