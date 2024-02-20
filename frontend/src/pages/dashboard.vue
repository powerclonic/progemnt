<template>
  <v-container>
    <div class="app-body">
      <h1 class="text-center app-body__title">
        Dashboard
      </h1>
      <card-wrapper class="projects-container">
        <h2>Mais recentes</h2>
        <div
          v-if="dashboardData"
          class="projects"
        >
          <div
            v-for="project, index in dashboardData.last_opened"
            :key="index"
            class="projects__card"
          >
            <div class="card__title">
              <p>
                {{ project.title }}
              </p>
              <router-link :to="'/'">
                acessar >
              </router-link>
            </div>
            <div class="card__infos">
              <p>
                Prazo: {{ new Date(project.deadline).toLocaleDateString('pt-BR') }}
              </p>
              <p>0/0 tarefas concluídas</p>
            </div>
          </div>
        </div>
      </card-wrapper>
      <card-wrapper class="projects-container projects-container--flex">
        <h2>
          Todos projetos
        </h2>
        <v-btn
          color="secondary-darken-1"
          flat
          prepend-icon="mdi-web"
          rounded="pill"
        >
          Todos os projetos
        </v-btn>
        <div>
          <v-btn
            color="secondary-darken-1"
            flat
            prepend-icon="mdi-account"
            rounded="pill"
            size="small"
            class="me-2"
          >
            Meus
          </v-btn>
          <v-btn
            color="secondary-darken-1"
            flat
            prepend-icon="mdi-account-multiple"
            rounded="pill"
            size="small"
            class="me-2"
          >
            De outros
          </v-btn>
          <v-btn
            color="secondary-darken-1"
            flat
            prepend-icon="mdi-star"
            rounded="pill"
            size="small"
          >
            Favoritos
          </v-btn>
        </div>
      </card-wrapper>
      <button class="app-body__button">
        <v-icon
          icon="mdi-plus"
          color="primary"
        /> Novo projeto
      </button>
      <card-wrapper class="projects-container">
        <h2>Recém atualizados</h2>
        <div
          v-if="dashboardData"
          class="projects"
        >
          <div
            v-for="project, index in dashboardData.last_updated"
            :key="index"
            class="projects__card"
          >
            <div class="card__title">
              <p>
                {{ project.title }}
              </p>
              <router-link :to="'/'">
                acessar >
              </router-link>
            </div>
            <div class="card__infos">
              <p>
                atualizado: {{ new Intl.DateTimeFormat("pt-br", { day: "2-digit", month: "2-digit", year: "2-digit", hour: "2-digit", minute: "2-digit" }).format(new Date(project.updated_at)) }}
              </p>
              <p>0/0 tarefas concluídas</p>
            </div>
          </div>
        </div>
      </card-wrapper>
      <card-wrapper class="projects-container projects-container--flex">
        <h2>Estatísticas</h2>
        <div v-if="dashboardData">
          <p>Total: {{ dashboardData.stats.total }}</p>
          <p>Em andamento: {{ dashboardData.stats.in_progress }}</p>
          <p>Finalizados: {{ dashboardData.stats.finished }}</p>
        </div>
      </card-wrapper>
    </div>
  </v-container>
</template>

<script setup lang="ts">
import { userDashboardData } from "@/api";
import { Ref } from "vue";
import { onMounted } from "vue";
import { ref } from "vue";

const dashboardData: Ref<any> = ref(null);

const getDashboardData = async () => {
  try {
    const res = await userDashboardData();

    dashboardData.value = res.data.data;

    console.log(dashboardData.value);

  } catch (error) {
    //
  }
};

onMounted(() => {
  getDashboardData();
});

</script>

<style scoped lang="scss">
.app-body {
  display: grid;
  grid-template-rows: auto;
  grid-template-columns: repeat(1, minmax(100px, 1fr));
  row-gap: 20px;

  &__button {
    font-weight: bolder;
    font-size: 1.75rem;
    background-color: rgb(var(--v-theme-secondary-darken-1));
    border-radius: 10px;
    padding: 1rem 0;

  }
}

.projects-container {
  padding: 10px;

  &--flex {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: space-between;
    gap: 10px;
  }
}

.projects {
  display: flex;
  overflow-x: scroll;
  gap: 10px;

  &__card {
    min-width: 250px;
    background-color: rgb(var(--v-theme-secondary-darken-1));
    border-radius: 10px;
    padding: 10px;

    & * {
      min-width: fit-content;
    }
  }
}

.card {
  &__title {
    margin-bottom: 1rem;

    display: flex;
    justify-content: space-between;

    & > p {
      font-weight: 500;
      font-size: 1.25rem;
    }

    & > a {
      text-decoration: none;
      color: rgb(var(--v-theme-secondary));      
      font-size: 0.9rem;
      align-items: center;
    }
  }

  &__infos {
    font-weight: 100;
    font-size: 0.8rem;
  }
}

@media screen and (min-width: 600px) {
  .app-body {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    grid-template-rows: repeat(4, 0.5fr);
    column-gap: 20px;

    &__button {
      grid-area: 3 / 1 / 4 / 3;
    }
    
    &__title {
      grid-area: 1 / 1 / 2 / 3;

      display: grid;
      place-content: center;
    }
  }

  .projects {
  & {
    scrollbar-width: thin;
    scrollbar-color: rgb(var(--v-theme-secondary)) rgb(var(--v-theme-secondary-darken-2));
  }

  &::-webkit-scrollbar {
    height: 6px;
    margin-top: 12px;
  }

  &::-webkit-scrollbar-track {
    background: rgb(var(--v-theme-secondary-darken-2));
  }

  &::-webkit-scrollbar-thumb {
    background-color: rgb(var(--v-theme-secondary));
    border-radius: 10px;
  }
  }
}
</style>