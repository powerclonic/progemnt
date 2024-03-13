<template>
  <v-dialog v-model="isActive" max-width="512">
    <template #activator="{ props: activatorProps }">
      <slot name="activator" :props="activatorProps" />
    </template>
    <v-sheet>
      <v-sheet>
        <v-form
          :disabled="store.loading || userLevel <= 2"
          @submit.prevent="sendForm"
        >
          <h2 class="mb-2">Alterar visibilidade</h2>
          <div class="card-info">
            <v-select v-model="projectModel.visibility" :items />
          </div>
          <v-btn
            block
            :disabled="store.loading || userLevel <= 2"
            type="submit"
          >
            Atualizar
          </v-btn>
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

const flash = useFlashStore();
const store = useAppStore();

const props = defineProps({
  project: {
    type: {} as PropType<Project>,
    required: true,
  },
});

const projectModel = ref({
  visibility: props.project.visibility,
});

const items = [
  {
    title: "Privado",
    value: 1,
  },
  {
    title: "Membros",
    value: 2,
  },
  {
    title: "Público",
    value: 3,
  },
];

const userLevel = props.project.users.find(
  (u) => u.id === store.user_id,
)?.permission;

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
