<template>
  <v-card
    min-width="45%"
    max-width="45%"
    class="d-flex flex-column mb-3"
    link
    @click="
      $router.push({
        path: `/projects/${project.id}`,
      })
    "
  >
    <v-card-item>
      <v-card-title> {{ project.title }} </v-card-title>
      <v-card-subtitle>{{ info }} </v-card-subtitle>
    </v-card-item>
    <v-card-actions class="mt-auto">
      <v-btn-darker block variant="text" color="primary">
        Acessar projeto
      </v-btn-darker>
    </v-card-actions>
  </v-card>
</template>

<script setup lang="ts">
import { Project } from "@/types";
import { PropType } from "vue";

defineProps({
  project: {
    type: {} as PropType<Project>,
    required: true,
  },
  info: {
    type: String,
    required: true,
  },
});
</script>
