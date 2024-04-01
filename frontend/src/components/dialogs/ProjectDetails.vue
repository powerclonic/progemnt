<template>
  <v-dialog v-model="isActive" max-width="512">
    <template #activator="{ props: activatorProps }">
      <slot name="activator" :props="activatorProps" />
    </template>
    <v-sheet>
      <v-sheet>
        <v-form :disabled="store.loading" @submit.prevent="sendForm">
          <h2>Detalhes do projeto</h2>
          <div class="card-info">
            <p>Título</p>
            <v-text-field v-model="projectModel.title" />
          </div>
          <div class="card-info">
            <p>Prazo</p>
            <v-text-field v-model="projectModel.deadline" type="date" />
          </div>
          <div class="card-info">
            <p>Link</p>
            <v-text-field :model-value="projectLink" readonly />
          </div>
          <v-btn block :disabled="store.loading" type="submit">Atualizar</v-btn>
        </v-form>
      </v-sheet>
    </v-sheet>
  </v-dialog>
</template>

<script setup lang="ts">
import { updateProject } from "@/api";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";
import { Project } from "@/types";
import { format } from "date-fns";

const flash = useFlashStore();
const store = useAppStore();

const props = defineProps({
  project: {
    type: {} as PropType<Project>,
    required: true,
  },
});

const projectModel = ref({
  title: props.project.title,
  deadline: format(new Date(props.project.deadline), "yyyy-MM-dd"),
});

const projectLink = `https://progemnt.mdresch.com.br/project/${props.project.id}`;

const isActive = ref(false);

const sendForm = async () => {
  try {
    await updateProject(props.project.id, projectModel.value);
    flash.setMessage("Projeto atualizado", "success");
    isActive.value = false;
  } catch (error) {
    //
  }
};
</script>
