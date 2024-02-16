<template>
  <v-alert
    v-if="store.error_message"
    class="text-left my-2"
    variant="tonal"
    type="error"
    density="compact"
    :text="store.error_message"
  />
</template>

<script setup lang="ts">
import { useErrorStore } from '@/store/error';

const store = useErrorStore();
</script>