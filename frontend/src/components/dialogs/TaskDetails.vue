<template>
  <v-dialog v-model="dialog" :activator="activator" scrollable>
    <v-card>
      <v-sheet class="card">
        <v-form @submit.prevent="sendForm">
          <h2>Detalhes da tarefa</h2>
          <div class="card__info">
            <p>Título</p>
            <v-text-field
              v-model="taskModel.title"
              variant="solo-filled"
              bg-color="secondary-darken-1"
              density="comfortable"
            />
          </div>
          <div class="card__info">
            <p>Descrição</p>
            <v-textarea
              v-model="taskModel.description"
              variant="solo-filled"
              bg-color="secondary-darken-1"
              density="comfortable"
            />
          </div>
          <div class="card__bottom">
            <div class="card__info">
              <p>Prazo</p>
              <v-text-field
                v-model="taskModel.deadline"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                type="date"
              />
            </div>
            <div class="card__info">
              <p>Status</p>
              <v-select
                v-model="taskModel.status"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                :items="statuses"
              />
            </div>
            <div class="card__info">
              <p>Responsável</p>
              <v-select
                v-model="taskModel.responsible"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                :items="responsibles"
              />
            </div>
          </div>
          <div class="card__buttons">
            <v-btn type="submit" :disabled="store.loading"> ATUALIZAR </v-btn>
            <confirm-action @confirm="removeTask">
              <template #activator="{ props: activatorProps }">
                <v-btn-darker
                  v-bind="activatorProps"
                  icon="mdi-trash-can"
                  class="text-primary"
                  :disabled="store.loading"
                />
              </template>
            </confirm-action>
          </div>
        </v-form>
      </v-sheet>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { deleteTask, updateTask } from "@/api";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";
import { format } from "date-fns";
import { ref } from "vue";

const store = useAppStore();

const emits = defineEmits(["update", "delete"]);

const props = defineProps({
  activator: {
    type: String,
    required: true,
  },
  task: {
    type: Object,
    required: true,
  },
  members: {
    type: Array,
    required: true,
  },
});

const statuses = [
  {
    title: "Não iniciada",
    value: 1,
  },
  {
    title: "Em andamento",
    value: 2,
  },
  {
    title: "Em espera",
    value: 3,
  },
  {
    title: "Concluida",
    value: 4,
  },
];

const responsibles = [
  ...props.members.map((val: any) => {
    return {
      title: val.name,
      value: val.id,
    };
  }),
  {
    title: "Ninguém",
    value: null,
  },
];

const dialog = ref(false);
const confirmDialog = ref(false);

const taskModel = ref({
  title: props.task.title,
  description: props.task.description,
  deadline: !props.task.deadline
    ? null
    : format(new Date(props.task.deadline), "yyyy-MM-dd"),
  responsible: props.task.responsible?.id ?? null,
  status: props.task.status,
});

const sendForm = async () => {
  try {
    await updateTask(props.task.id, taskModel.value);

    useFlashStore().setMessage("Tarefa atualizada", "success");
    emits("update", taskModel);
    dialog.value = false;
  } catch (error) {
    //
  }
};

const removeTask = async () => {
  try {
    await deleteTask(props.task.id);

    dialog.value = false;
    confirmDialog.value = false;

    emits("delete");
  } catch (error) {
    //
  }
};
</script>

<style scoped lang="scss">
@import "@/styles/informationCard.scss";
</style>
