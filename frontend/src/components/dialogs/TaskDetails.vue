<template>
  <v-dialog
    v-model="dialog"
    :activator="activator"
    scrollable
  >
    <v-card>
      <card-wrapper class="card">
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
            <the-button
              colorful
              type="submit"
            >
              ATUALIZAR
            </the-button>
            <v-dialog
              v-model="confirmDialog"
              transition="dialog-bottom-transition"
            >
              <template #activator="{ props: activatorProps }">
                <v-btn
                  v-bind="activatorProps"
                  icon="mdi-trash-can"
                  class="text-primary"
                  variant="text"
                />
              </template>
              <template #default="{ isActive }">
                <card-wrapper class="confirm">
                  <h2 class="confirm__title">
                    Tem certeza?
                  </h2>
                  <p class="confirm__subtitle">
                    Ao excluir uma tarefa, você não poderá restaurá-la
                  </p>
                  <div class="confirm__buttons">
                    <the-button
                      lighter
                      :loading="store.loading"
                      :disabled="store.loading"
                      @click="removeTask"
                    >
                      EXCLUIR
                    </the-button>
                    <the-button
                      colorful
                      :disabled="store.loading"
                      @click="isActive.value = false"
                    >
                      CANCELAR
                    </the-button>
                  </div>
                </card-wrapper>
              </template>
            </v-dialog>
          </div>
        </v-form>
      </card-wrapper>
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
    required: true
  },
  task: {
    type: Object,
    required: true
  },
  members: {
    type: Array,
    required: true
  }
});

const statuses = [
  {
    title: "Não iniciada",
    value: 1
  },
  {
    title: "Em andamento",
    value: 2
  },
  {
    title: "Em espera",
    value: 3
  },
  {
    title: "Concluida",
    value: 4
  },
];

const responsibles = [...props.members.map((val: any) => {
  return { 
    title: val.name,
    value: val.id
  };
}), {
  title: "Ninguém",
  value: null
}];

const dialog = ref(false);
const confirmDialog = ref(false);

const taskModel = ref({
  title: props.task.title,
  description: props.task.description,
  deadline: !props.task.deadline ? null : format(new Date(props.task.deadline), "yyyy-MM-dd"),
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
    .card  {
        padding: 20px;

        &__buttons {
            display: grid;
            grid-template-columns: auto 3rem;
            gap: 10px;

            align-items: center;
        }
    }

    .confirm{
        padding: 20px;

        margin: 0 auto;

        max-width: fit-content;
        
        &__subtitle {
            margin-bottom: 20px;
        }

        &__buttons {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
    }
}

    @media screen and (min-width: 600px) {
    .card {
        &__bottom {
            display: flex;
            justify-content: space-between;
            gap: 10px;

            & * {
                width: 100%;
            }
        }
    }

    }
</style>