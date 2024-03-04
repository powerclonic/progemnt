<template>
  <v-dialog
    v-model="newTaskDialog"
    class="dialog"
  >
    <card-wrapper class="dialog__body elevation-8">
      <h2 class="dialog__title">
        Nova tarefa
      </h2>
      <v-form @submit.prevent="sendTaskForm">
        <v-text-field
          v-model="taskModel.title"
          label="Título"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
        />
        <v-text-field
          v-model="taskModel.description"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="Descrição"
          rounded="lg"
        />
        <v-text-field
          v-model="taskModel.deadline"
          label="Prazo"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="date"
          rounded="lg"
        />
        <v-select
          v-model="taskModel.responsible"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="Responsável"
          rounded="lg"
          :items="taskResponsibles"
        />
        <the-button
          flat
          block
          colorful
          type="submit"
          :disabled="store.loading"
          :loading="store.loading"
        >
          criar
        </the-button>
      </v-form>
    </card-wrapper>
  </v-dialog>
  <v-container
    v-if="project"
    class="app-body"
  >
    <div class="title">
      <p class="title__aux">
        Projeto
      </p>
      <h1 class="title__main">
        {{ project.title }}
      </h1>
    </div>
    <card-wrapper class="configs">
      <h3>Configurações do projeto</h3>
      <div class="configs__buttons">
        <project-members
          :members="project.users"
          :project-id="project.id"
        >
          <template #activator="{ props: activatorProps }">
            <v-btn
              v-bind="activatorProps"
              prepend-icon="mdi-account-multiple"
              size="small"
              rounded="pill"
              color="secondary-darken-1"
              flat
            >
              Membros
            </v-btn>
          </template>
        </project-members>
        <v-btn
          prepend-icon="mdi-information"
          size="small"
          rounded="pill"
          color="secondary-darken-1"
          flat
        >
          Detalhes
        </v-btn>
        <v-btn
          prepend-icon="mdi-web"
          size="small"
          rounded="pill"
          color="secondary-darken-1"
          flat
        >
          Visibilidade
        </v-btn>
        <v-btn
          prepend-icon="mdi-clipboard"
          size="small"
          rounded="pill"
          color="secondary-darken-1"
          flat
        >
          Alterações
        </v-btn>
      </div>
    </card-wrapper>
    <card-wrapper class="description">
      <h3>Descrição do projeto</h3>
      <p class="description__text">
        {{ project.description }}
      </p>
    </card-wrapper>
    <card-wrapper class="details">
      <h3>Detalhes do projeto</h3>
      <div class="details__chips">
        <v-chip prepend-icon="mdi-account">
          por {{ project.users[0].name }}
        </v-chip>
        <v-chip prepend-icon="mdi-calendar">
          iniciado {{ getRelative(project.created_at) }}
        </v-chip>
        <v-chip prepend-icon="mdi-file-edit">
          atualizado {{ getRelative(project.updated_at) }}
        </v-chip>
        <v-chip prepend-icon="mdi-clock-alert">
          {{ format(new Date(project.deadline), "dd/MM/yyyy") }}
        </v-chip>
        <v-chip prepend-icon="mdi-account">
          {{ project.users.length }} {{ project.users.length > 1 ? 'membros' : 'membro' }} 
        </v-chip>
        <v-chip prepend-icon="mdi-list-status">
          0/0 tarefas
        </v-chip>
      </div>
    </card-wrapper>
    <card-wrapper class="tasks">
      <div class="tasks__title">
        <div class="tasks__title-left">
          <h2>Tarefas</h2>
          <p>0 de 0 tarefas completadas</p>
        </div>
        <button
          class="tasks__title-right"
          @click="newTaskDialog = true"
        >
          nova tarefa
          <v-icon
            icon="mdi-plus"
            color="primary"
          />
        </button>
      </div>  
      <div class="tasks__container">
        <card-wrapper
          v-for="task, index in project.tasks"
          :key="index"
          class="task-card"
        >
          <div class="task-card__title">
            <h3>{{ task.title }}</h3>
            <p :id="'task_dialog_' + index">
              acessar >
            </p>
            <task-details
              :activator="'#task_dialog_' + index"
              :task="task"
              :members="project.users"
              @update="(t: Ref<any>) => updateTask(t, index)"
              @delete="() => deleteTask(index)"
            />
          </div>
          <div class="task-card__footer">
            <p
              v-if="task.responsible"
              class="task-card__responsible"
            >
              <v-icon icon="mdi-account" /> {{ task.responsible.name }}
            </p>
            <p
              v-else
              class="task-card__responsible"
            >
              <v-icon icon="mdi-account-cancel" /> Sem responsável
            </p>
            <v-chip
              class="task-card__status"
              v-bind="getStatusConfig(task.status)"
            />
          </div>
        </card-wrapper>
      </div>
    </card-wrapper>
  </v-container>
  <v-container
    v-else
    class="skeleton-container"
  >
    <v-skeleton-loader
      type="text"
      width="150"
    />
    <v-skeleton-loader
      type="heading"
      width="300"
    />
    <v-skeleton-loader
      type="image"
      class="w-100"
    />
    <v-skeleton-loader
      type="image"
      class="w-100"
    />
    <v-skeleton-loader
      type="image"
      class="w-100"
    />
  </v-container>
</template>

<script setup lang="ts">
import { createTask, showProject } from "@/api";
import { Ref, onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router/auto";

import { formatDistance, format } from "date-fns";
import { ptBR } from "date-fns/locale/pt-BR";
import { Project } from "@/types";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";
import { computed } from "vue";

const getRelative = (date: string) => {
  const today = new Date();
  const relDate = new Date(date);

  return formatDistance(relDate, today, { locale: ptBR, addSuffix: true });
};

const route = useRoute();
const store = useAppStore();

const project: Ref<Project|null> = ref(null);
const newTaskDialog: Ref<boolean> = ref(false);

//* Task v-models
const taskModel = ref({
  title: "", 
  deadline: null, 
  responsible: null, 
  description: null, 
});

const taskResponsibles = computed(() => {
  if (!project.value) return;

  return [
    ...project.value.users.map((val: any) => {
      return { 
        title: val.name,
        value: val.id
      };
    }),
    {
      title: "Ninguém",
      value: null
    }
  ];
});

const getStatusConfig = (status: number) => {
  switch (status) {
  case 1: 
    return {
      text: "Não iniciada",
      color: "error",
      prependIcon: "mdi-alert-circle"
    };
  case 2: 
    return {
      text: "Em andamento",
      color: "info",
      prependIcon: "mdi-clock"
    };
  case 3: 
    return {
      text: "Em espera",
      color: "warning",
      prependIcon: "mdi-alert-octagon"
    };
  case 4: 
    return {
      text: "Concluída",
      color: "success",
      prependIcon: "mdi-check-circle"
    };
  }
};

const updateTask = (t: Ref<any>, i: number) => {
  if (! project.value) return;

  project.value.tasks[i] = Object.assign(project.value.tasks[i], t.value);

  project.value.tasks[i].responsible = project.value.users.find((u: any) => u.id = t.value.responsible);
};

const deleteTask = (i: number) => {
  project.value?.tasks.splice(i, 1);
};

const getData = async () => { 
  try {
    // @ts-expect-error
    const res = await showProject(route.params.id);

    project.value = res.data.data;
  } catch (error) {
    //
  }
};

const sendTaskForm = async () => {
  try {
    await createTask(project.value?.id, taskModel.value);

    taskModel.value = {
      title: "", 
      deadline: null, 
      responsible: null, 
      description: null,  
    };

    newTaskDialog.value = false;
    useFlashStore().setMessage("Tarefa adicionada", "success");

    getData();
  } catch (error) {
    //
  }
};

onMounted(() => {
  getData();
});
</script>

<style scoped lang="scss">
.app-body {
  display: grid;
  grid-template-columns: minmax(0, 1fr);
  grid-template-rows: auto;
  gap: 10px;

  height: 100%;
}

.title {
  text-align: center;

  &__aux {
    color: rgb(var(--v-theme-secondary));
    font-size: 0.8rem;
  }

  &__main {
    font-size: 1.25rem;
  }
}

.configs {
  padding: 10px;
  &__buttons {
    display: flex;
    overflow-x: scroll;

    max-width: 100%;

    gap: 5px;
    margin-top: 10px;
  }
}

.description {
  padding: 10px;

  &__text {
    max-width: 100%;
    word-wrap: break-word;
    max-height: 4.5rem;
    text-overflow: ellipsis;
    overflow: hidden scroll;
    line-height: 1.5rem;
    height: 100%;
  }
}

.details {
  padding: 10px;

  &__chips {
    display: flex;
    flex-wrap: wrap;

    gap: 5px;
    margin-top: 10px;
  }
}

.tasks {
  padding: 10px;
  overflow: hidden;
  
  &__title {
    display: flex;
    justify-content: space-between;

    margin-bottom: 10px;
  }

  &__title-left {
    & > p {
      color: rgb(var(--v-theme-secondary));
      margin-top: -10px;
    }
  }

  &__title-right {
    display: flex;
    align-items: center;
  }

  &__container {
    display: flex;
    flex-direction: column;
    gap: 10px;
    border-radius: 10px;
  }
}

.task-card {
  padding: 10px;
  background-color: rgb(var(--v-theme-secondary-darken-1));

  &__title {
    display: flex;
    justify-content: space-between;

    & > h3 {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    & > p {
      white-space: nowrap;
      margin-left: 10px;
      color: rgb(var(--v-theme-secondary));
    }
  }

  &__footer {
    display: flex;
    justify-content: space-between;

    margin-top: 20px;
  }

  &__responsible {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-right: 8px;
  }

  &__status {
    width: 175px;
  }
}

.skeleton-container {
  display: grid;
  grid-template-rows: repeat(5, auto);
  grid-template-columns: 1fr;
  place-items: center;
  justify-content: center;
  row-gap: 10px;
}

.dialog {
  &__title {
    text-align: center;
    margin-bottom: 10px;
  }

  &__body {
    background-color: rgb(var(--v-theme-surface));
    padding: 20px;

    max-width: 512px;
    width: 100%;

    margin: auto;
   }
}

@media screen and (min-width: 600px) {
  .app-body {
    grid-template-columns: 0.75fr 1.25fr;
    grid-template-rows: auto repeat(3, minmax(0, 1fr));
    max-height: calc(100vh - 68px - 80px);
  }

  .title {
    grid-area: 1 / 1 / 2 / 3;
  }

  .configs {
    &__buttons {
      flex-wrap: wrap;
      overflow-x: unset;
    }
  }

  .details, .description {
    & > h3 {
        height: 2rem;
    }

    &__chips, &__text {
        max-width: 100%;
        overflow: hidden scroll;
        height: calc(100% - 2rem - 10px);
        max-height: unset;
    }
  }

  .tasks {
    grid-area: 2 / 2 / 5 / 3; 

    &__title {
        height: 50px;
    }

    &__container {
        overflow-y: scroll;
    height: calc(100% - 60px);
    }
  }
}
</style>
