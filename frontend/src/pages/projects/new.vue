<template>
  <v-container class="h-100 py-8">
    <v-form
      class="app-form"
      :disabled="store.loading"
      @submit.prevent="sendForm"
    >
      <h2 class="app-form__title">Novo projeto</h2>
      <v-sheet class="input-card">
        <p class="input-card__label">Título</p>
        <v-text-field
          v-model="title"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          placeholder="Sistema de estoque..."
        />
      </v-sheet>
      <v-sheet class="input-card">
        <p class="input-card__label">Prazo para conclusão</p>
        <v-text-field
          v-model="deadline"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          placeholder="Sistema de estoque..."
          type="date"
        />
      </v-sheet>
      <v-sheet class="input-card app-form__div1">
        <p class="input-card__label">Descrição</p>
        <v-textarea
          v-model="description"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          placeholder="Projeto que irá ser desenvolvido para gerenciar o estoque da empresa X..."
          max="4096"
          counter
        />
      </v-sheet>
      <v-sheet class="input-card">
        <p class="input-card__label">Visibilidade</p>
        <v-select
          v-model="visibility"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          :items="visibilityValues"
          selected="Convidados"
        />
      </v-sheet>
      <v-btn
        block
        size="xl"
        type="submit"
        class="h-100"
        min-height="64px"
        :disabled="store.loading"
        :loading="$app.loading"
      >
        Criar projeto
      </v-btn>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { createProject } from "@/api";
import { useAppStore } from "@/store/app";
import { ref } from "vue";
import { useRouter } from "vue-router/auto";
import { definePage } from "vue-router/auto";

definePage({
  meta: {
    requireAuth: true,
  },
});

const store = useAppStore();
const router = useRouter();

const visibilityValues = [
  {
    title: "Público",
    value: 3,
  },
  {
    title: "Convidados",
    value: 2,
  },
  {
    title: "Privado",
    value: 1,
  },
];

const title = ref("");
const description = ref("");
const deadline = ref("");
const visibility = ref(2);

const sendForm = async () => {
  try {
    const res = await createProject({
      title: title.value,
      description: description.value,
      deadline: deadline.value,
      visibility: visibility.value,
    });

    router.push(`/projects/${res.data.id}`);
  } catch (error) {
    //
  }
};
</script>

<style scoped lang="scss">
.app-form {
  display: grid;
  grid-template-rows: auto;
  grid-template-columns: 1fr;
  gap: 20px;

  align-items: center;
  align-content: center;

  height: 100%;

  &__title {
    text-align: center;
  }
}
.input-card {
  padding: 10px;

  &__label {
    font-size: 1.25rem;
    margin-bottom: 10px;
  }
}

@media screen and (min-width: 600px) {
  .app-form {
    grid-template-rows: auto;
    grid-template-columns: repeat(2, 1fr);

    height: 100%;

    &__title {
      grid-area: 1 / 1 / 2 / 3;
    }

    &__div1 {
      grid-area: 3 / 1 / 4 / 3;
    }
  }
}
</style>
