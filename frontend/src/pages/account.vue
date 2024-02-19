<template>
  <v-container class="app-body">
    <h1>Minha conta</h1>
    <v-form class="app-form">
      <card-wrapper class="app-card">
        <h2>Nome</h2>
        <v-text-field
          :value="store.user_name"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          disabled
          density="compact"
          rounded="lg"
        />
      </card-wrapper>
      <card-wrapper class="app-card">
        <h2>E-mail</h2>
        <v-text-field
          v-model="email"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
          density="compact"
          :loading="store.loading"
        />
      </card-wrapper>
      <card-wrapper class="app-card div1">
        <h2>Senha</h2>
        <v-text-field
          v-model="curPassword"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="senha atual"
          density="compact"
          rounded="lg"
        />
        <v-text-field
          v-model="newPassword"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="nova senha"
          density="compact"
          rounded="lg"
        />
        <v-text-field
          v-model="conPassword"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="confirmar senha"
          density="compact"
          rounded="lg"  
        />
        <the-button
          colorful
          flat
          block
        >
          atualizar
        </the-button>
      </card-wrapper>
      <the-button
        colorful
        flat
        block
        class="action-btn"
      >
        encerrar sessão
      </the-button>
      <the-button
        flat
        block
        class="action-btn"
      >
        deletar conta
      </the-button>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { userData } from "@/api";
import { useAppStore } from "@/store/app";
import { onMounted } from "vue";
import { ref } from "vue";

const store = useAppStore();

const email = ref("");

const curPassword = ref("");
const newPassword = ref("");
const conPassword = ref("");

const getData = async () => {
  try {
    const res = await userData();

    email.value = res.data.data.email;

  } catch(error) {
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
  height: 100%;
}

.app-form {
  display: grid;
  grid-row-gap: 20px;

  @media screen and (min-width: 600px) {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(3, 1fr);
    grid-column-gap: 20px;

    & .div1 {
     grid-area: 2 / 1 / 4 / 2;
    } 

    & .action-btn {
      height: 100%;
    }
  }
}
.app-card {
  padding: 8px 12px;

  & > h2 {
    margin-bottom: 12px;
  }
}
</style>