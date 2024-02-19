<template>
  <v-alert
    v-if="store.flash_type"
    class="text-left my-2"
    variant="tonal"
    :type="store.flash_type"
    density="compact"
    :text="store.flash_message"
  />
</template>

<script setup lang="ts">
import { useFlashStore } from "@/store/flash";

const store = useFlashStore();
</script>