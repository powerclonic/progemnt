<template>
  <v-container class="h-100">
    <div class="app-body">
      <h1 class="text-center app-body__title">Dashboard</h1>
      <v-sheet class="projects-container">
        <h2>Mais recentes</h2>
        <div v-if="dashboardData" class="projects">
          <project-card-preview
            v-for="(project, index) in dashboardData.last_opened"
            :key="index"
            :project
            info="0 de 0 tarefas completadas"
          />
        </div>
        <div v-else class="projects">
          <project-card-preview-loader v-for="i in 3" :key="i" />
        </div>
      </v-sheet>
      <v-sheet class="projects-container projects-container--flex">
        <h2>Todos projetos</h2>
        <v-container v-if="dashboardData" class="px-0">
          <v-row>
            <v-col>
              <v-btn-chip prepend-icon="mdi-web">
                Todos os projetos
              </v-btn-chip>
            </v-col>
          </v-row>
          <v-row dense>
            <v-col cols="auto">
              <v-btn-chip prepend-icon="mdi-account" size="small">
                Meus
              </v-btn-chip>
            </v-col>
            <v-col cols="auto">
              <v-btn-chip prepend-icon="mdi-account-multiple" size="small">
                De outros
              </v-btn-chip>
            </v-col>
            <v-col cols="auto">
              <v-btn-chip prepend-icon="mdi-star" size="small">
                Favoritos
              </v-btn-chip>
            </v-col>
          </v-row>
        </v-container>
        <v-container v-else>
          <v-skeleton-loader width="40%" color="transparent" type="heading" />
          <v-skeleton-loader width="60%" color="transparent" type="chip@3" />
        </v-container>
      </v-sheet>
      <v-btn-dark
        :disabled="!dashboardData"
        class="app-body__button text-white h-100"
        prepend-icon="mdi-plus"
        @click="$router.push('/projects/new')"
      >
        Novo projeto
      </v-btn-dark>
      <v-sheet class="projects-container">
        <h2>Recém atualizados</h2>
        <div v-if="dashboardData" class="projects">
          <project-card-preview
            v-for="(project, index) in dashboardData.last_updated"
            :key="index"
            :project
            :info="`atualizado em ${dateFormatter.format(new Date(project.updated_at))}`"
          />
        </div>
        <div v-else class="projects">
          <project-card-preview-loader v-for="i in 3" :key="i" />
        </div>
      </v-sheet>
      <v-sheet class="projects-container projects-container--flex">
        <h2>Estatísticas</h2>
        <div v-if="dashboardData">
          <p>Total: {{ dashboardData.stats.total }}</p>
          <p>Em andamento: {{ dashboardData.stats.in_progress }}</p>
          <p>Finalizados: {{ dashboardData.stats.finished }}</p>
        </div>
        <div v-else class="w-100">
          <v-skeleton-loader width="50%" type="text@3" color="transparent" />
        </div>
      </v-sheet>
    </div>
  </v-container>
</template>

<script setup lang="ts">
import { userDashboardData } from "@/api";
import { Ref } from "vue";
import { onMounted } from "vue";
import { ref } from "vue";

const dateFormatter = new Intl.DateTimeFormat("pt-br", {
  day: "2-digit",
  month: "2-digit",
  year: "2-digit",
  hour: "2-digit",
  minute: "2-digit",
});

const dashboardData: Ref<any> = ref(null);

const getDashboardData = async () => {
  try {
    const res = await userDashboardData();

    dashboardData.value = res.data.data;
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

  min-height: 100%;

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
  height: calc(100% - 36px);
  &__card {
    min-width: 250px;
    background-color: rgb(var(--v-theme-secondary-darken-1));
    border-radius: 10px;
    padding: 10px;

    overflow: hidden;
  }
}

.card {
  &__title {
    margin-bottom: 1rem;

    display: flex;
    justify-content: space-between;

    & > p {
      white-space: nowrap;
      text-overflow: ellipsis;
      overflow: hidden;

      font-weight: 500;
      font-size: 1.25rem;
    }

    & > a {
      text-decoration: none;
      color: rgb(var(--v-theme-secondary));
      font-size: 0.9rem;
      align-items: center;
      min-width: fit-content;
      margin-left: 5px;
    }
  }

  &__infos {
    font-weight: 100;
    font-size: 0.8rem;
  }
}

@media screen and (min-width: 768px) {
  .app-body {
    grid-template-columns: repeat(2, minmax(0, 1fr));
    grid-template-rows: auto 1fr 128px 1fr;
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
}
</style>
