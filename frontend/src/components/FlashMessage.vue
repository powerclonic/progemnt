<template>
  <v-snackbar
    v-model="store.flash_value"
    timeout="10000"
    class="snackbar"
    :color="store.flash_type"
    absolute
    variant="tonal"
  >
    <div class="snackbar__content">
      <v-icon
        :icon="store.flash_icon"
        class="snackbar__icon"
      />
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
.snackbar {
    &__content {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    &__icon {
        font-size: 1.75rem;
    }

    &__text {
        font-size: 1.25rem;
    }
}
</style>