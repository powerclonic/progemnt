<template>
  <v-container>
    <h2 class="text-center my-2">Projetos</h2>
    <card-wrapper class="filter">
      <h2>Filtrar por:</h2>
      <v-chip-group v-model="filterSelect" selected-class="bg-primary" column>
        <v-chip prepend-icon="mdi-web" value="all"> Todos </v-chip>
        <v-chip prepend-icon="mdi-account" value="user"> Meus projetos </v-chip>
        <v-chip prepend-icon="mdi-account-multiple" value="shared">
          Compartilhados
        </v-chip>
        <v-chip prepend-icon="mdi-star" value="favs"> Favoritos </v-chip>
      </v-chip-group>
    </card-wrapper>
    <div v-if="projects" class="projects">
      <card-wrapper
        v-for="(project, index) in projects"
        :key="index"
        class="projects__card"
      >
        <button
          class="card__container"
          @click="$router.push(`/projects/${project.id}}`)"
        >
          <h2 class="card__title">
            {{ project.title }}
          </h2>
          <p class="card__owner">de {{ project.users[0].name }}</p>
          <p class="card__description">
            {{ project.description }}
          </p>
          <div>
            <v-chip size="small" prepend-icon="mdi-list-status" class="me-1">
              0/0
            </v-chip>
            <v-chip class="me-1" size="small" prepend-icon="mdi-calendar">
              {{ new Date(project.deadline).toLocaleDateString("pt-br") }}
            </v-chip>
            <v-chip size="small" prepend-icon="mdi-account-multiple">
              {{ project.users.length }}
              {{ project.users.length > 1 ? "membros" : "membro" }}
            </v-chip>
          </div>
        </button>
      </card-wrapper>
      <button @click="$router.push('/projects/new')">
        <v-icon icon="mdi-plus" color="primary" /> Novo projeto
      </button>
    </div>
    <div v-else-if="store.loading || true" class="skeleton">
      <v-skeleton-loader type="image" />
      <v-skeleton-loader type="image" />
    </div>
    <div v-else class="empty-msg">Oops! Parece que não há nada aqui.</div>
  </v-container>
</template>

<script setup lang="ts">
import { userProjects } from "@/api";
import { useAppStore } from "@/store/app";
import { onMounted } from "vue";
import { computed } from "vue";
import { ref } from "vue";
import { Ref } from "vue";
import { definePage } from "vue-router/auto";

definePage({
  meta: {
    requireAuth: true,
  },
});

const store = useAppStore();

const filterSelect: Ref<"all" | "user" | "shared" | "favs"> = ref("all");

const projects = ref(null);
const filteredProjects = computed(() => "oi");

const getData = async () => {
  try {
    const res = await userProjects();

    projects.value = res.data.data;

    console.log(projects.value);
  } catch (error) {
    //
  }
};

onMounted(() => {
  getData();
});
</script>

<style scoped lang="scss">
.filter {
  padding: 10px;

  &__buttons {
    margin-top: 10px;

    display: flex;
    overflow-x: auto;
    gap: 10px;
  }
}

.projects {
  display: grid;
  grid-template-columns: repeat(1, minmax(0, 1fr));
  grid-template-rows: auto;
  gap: 10px;

  margin-top: 20px;
}

.skeleton {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 10px;
  padding: 20px 0;
}

.card {
  &__container {
    width: 100%;
    text-align: left;
    padding: 10px;

    &:focus {
      transition: background 0.5s;
      outline: 0;
      background-color: rgba(var(--v-theme-secondary), 25%);
      border-radius: 10px;
    }
  }

  &__title {
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }

  &__owner {
    font-size: 0.8rem;
    color: rgb(var(--v-theme-secondary));
    margin-top: -10px;
  }

  &__description {
    margin: 5px 0;
    max-width: 100%;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
}

.empty-msg {
  color: rgb(var(--v-theme-secondary));
  text-align: center;
  font-weight: bold;

  padding: 1rem 0;
}

@media screen and (min-width: 600px) {
  .projects {
    grid-template-columns: repeat(2, minmax(0, 1fr));
  }
}
</style>
