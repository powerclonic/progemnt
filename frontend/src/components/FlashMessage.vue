<template>
  <v-snackbar
    v-model="store.flash_value"
    :color="store.flash_type"
    timeout="10000"
  >
    {{ store.flash_message }}
  </v-snackbar>
</template>

<script setup lang="ts">
import { useFlashStore } from "@/store/flash";

const store = useFlashStore();
</script>
