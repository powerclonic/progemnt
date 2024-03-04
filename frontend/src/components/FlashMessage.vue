<template>
  <v-snackbar
    v-model="store.flash_value"
    timeout="-1"
    class="text-left my-2"
    variant="tonal"
    :color="store.flash_type"
    density="compact"
    :title="store.flash_message"
  />
</template>

<script setup lang="ts">
import { useFlashStore } from "@/store/flash";

const store = useFlashStore();
</script>