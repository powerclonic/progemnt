<template>
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
        <v-btn
          prepend-icon="mdi-account-multiple"
          size="small"
          rounded="pill"
          color="secondary-darken-1"
          flat
        >
          Membros
        </v-btn>
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
      <v-chip
        size="small"
        prepend-icon="mdi-account"
      >
        por {{ project.users[0].name }}
      </v-chip>
      <v-chip
        size="small"
        prepend-icon="mdi-calendar"
      >
        iniciado {{ getRelative(project.created_at) }}
      </v-chip>
      <v-chip
        size="small"
        prepend-icon="mdi-file-edit"
      >
        atualizado {{ getRelative(project.updated_at) }}
      </v-chip>
      <v-chip
        size="small"
        prepend-icon="mdi-clock-alert"
      >
        {{ format(new Date(project.deadline), "dd/MM/yyyy") }}
      </v-chip>
      <v-chip
        size="small"
        prepend-icon="mdi-account"
      >
        criado por {{ project.users[0].name }}
      </v-chip>
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
import { showProject } from "@/api";
import { Ref, onMounted } from "vue";
import { ref } from "vue";
import { useRoute } from "vue-router/auto";

import { formatDistance, format } from "date-fns";
import { ptBR } from "date-fns/locale/pt-BR";
import { Project } from "@/types";

const getRelative = (date: string) => {
  const today = new Date();
  const relDate = new Date(date);

  return formatDistance(relDate, today, { locale: ptBR, addSuffix: true });
};

const route = useRoute();

const project: Ref<Project|null> = ref(null);

const getData = async () => { 
  try {
    // @ts-expect-error
    const res = await showProject(route.params.id);

    project.value = res.data.data;
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
  grid-template-columns: 1fr;
  grid-template-rows: auto;
  gap: 10px;
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
</style>
