<template>
  <v-dialog max-width="512">
    <template #activator="{ props: activatorProps }">
      <slot name="activator" :props="activatorProps" />
    </template>
    <v-sheet>
      <v-sheet>
        <h2 class="mb-2">Alterações do projeto</h2>
        <v-timeline side="end" align="start" density="compact">
          <!-- falta o back -->
        </v-timeline>
      </v-sheet>
    </v-sheet>
  </v-dialog>
</template>

<script setup lang="ts">
import { Project } from "@/types";

const props = defineProps({
  project: {
    type: {} as PropType<Project>,
    required: true,
  },
});

props;
</script>
