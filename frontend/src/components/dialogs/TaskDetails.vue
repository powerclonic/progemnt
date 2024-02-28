<template>
  <v-dialog
    :activator="activator"
    scrollable
  >
    <v-card>
      <card-wrapper class="card">
        <v-form @submit.prevent="() => {}">
          <h2>Detalhes da tarefa</h2>
          <div class="card__info">
            <p>Título</p>
            <v-text-field
              v-model="title"
              variant="solo-filled"
              bg-color="secondary-darken-1"
              density="comfortable"
            />
          </div>
          <div class="card__info">
            <p>Descrição</p>
            <v-textarea
              v-model="description"
              variant="solo-filled"
              bg-color="secondary-darken-1"
              density="comfortable"
            />
          </div>
          <div class="card__bottom">
            <div class="card__info">
              <p>Prazo</p>
              <v-text-field
                v-model="deadline"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                type="date"
              />
            </div>
            <div class="card__info">
              <p>Status</p>
              <v-select
                v-model="status"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                :items="statuses"
              />
            </div>
            <div class="card__info">
              <p>Responsável</p>
              <v-select
                v-model="responsible"
                variant="solo-filled"
                bg-color="secondary-darken-1"
                density="comfortable"
                :items="responsibles"
              />
            </div>
          </div>
          <the-button
            block
            colorful
          >
            ATUALIZAR
          </the-button>
        </v-form>
      </card-wrapper>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { format } from "date-fns";
import { ref } from "vue";

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

const title = ref(props.task.title);
const description = ref(props.task.description);
const deadline = ref(format(new Date(props.task.deadline), "yyyy-MM-dd"));
const responsible = ref(props.task.responsible?.name);
const status = ref(props.task.status);

</script>

<style scoped lang="scss">
    .card{
        padding: 20px;

        // &__bottom {
        //     display: flex;
        //     justify-content: space-between;
        //     gap: 10px;

        //     & * {
        //         width: 100%;
        //     }
        // }
    }
</style>