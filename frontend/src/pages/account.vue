<template>
  <v-container class="app-body">
    <h1 class="text-center">
      Minha conta
    </h1>
    <flash-message />
    <v-form
      v-model="form"
      class="app-form"
      validate-on="input"
      @submit.prevent="updateUser"
    >
      <card-wrapper class="app-card">
        <h2>Nome</h2>
        <v-text-field
          :value="store.user_name"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          readonly
          rounded="lg"
        />
      </card-wrapper>
      <card-wrapper class="app-card">
        <h2>Nome de usuário</h2>
        <v-text-field
          :value="username"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
          readonly
        />
      </card-wrapper>
      <card-wrapper class="app-card">
        <h2>E-mail</h2>
        <v-text-field
          :value="email"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
          readonly
        />
      </card-wrapper>
      <card-wrapper class="app-card div1">
        <h2>Senha</h2>
        <v-text-field
          v-model="curPassword"
          variant="solo-filled"
          class="mb-2"
          bg-color="secondary-darken-1"
          type="password"
          label="senha atual"
          rounded="lg"
          :rules="[rules.required, rules.maxLength]"
        />
        <v-text-field
          v-model="newPassword"
          class="mb-2"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          label="nova senha"
          type="password"
          rounded="lg"
          :rules="[rules.required, rules.maxLength, rules.passwordFormat]"
        />
        <v-text-field
          v-model="conPassword"
          class="mb-2"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="password"
          label="confirmar senha"
          rounded="lg"
          :rules="[rules.required, rules.maxLength, rules.equal]"
        />
        <the-button
          colorful
          flat
          block
          type="submit"
          :loading="store.loading"
          :disabled="store.loading || !form"
        >
          atualizar
        </the-button>
      </card-wrapper>
      <the-button
        colorful
        flat
        block
        class="action-btn"
        @click="destroySession"
      >
        encerrar sessão
      </the-button>
      <the-button
        block
        class="action-btn"
        disabled
        @click="deleteAccount"
      >
        deletar conta
      </the-button>
    </v-form>
  </v-container>
</template>

<script setup lang="ts">
import { signOut, userData, userDestroy, userUpdate } from "@/api";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";
import { onMounted } from "vue";
import { ref } from "vue";
import { useRouter, definePage } from "vue-router/auto";

definePage({
  meta: {
    requireAuth: true
  }
});

const store = useAppStore();
const flashStore = useFlashStore();
const router = useRouter();

const form = ref(false);
const email = ref("");
const username = ref("");

const curPassword = ref("");
const newPassword = ref("");
const conPassword = ref("");

const passwordRegexp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])\S{8,}$/;

const rules = {
  required: (value: any) => !!value || "Obrigatório",
  maxLength: (value: any) => value.length <= 512 || "Número máximo de caracteres atingido",

  passwordFormat: (value: any) => !!passwordRegexp.exec(value) || "A senha deve ter no mínimo 8 caracteres e conter letras maiúsculas e minúsculas, números e caracteres especiais.",

  equal: (value: any) => value === newPassword.value || "As senhas não são iguais",
};

const getData = async () => {
  try {
    const res = await userData();

    email.value = res.data.data.email;
    username.value = res.data.data.username;

  } catch (error) {
    //
  }
};

const destroySession = async () => {
  await signOut();

  store.unsetAuthData();
  flashStore.setMessage("Sessão encerrada", "success");

  router.push("/signin");
};

const deleteAccount = async () => {
  await userDestroy();

  store.unsetAuthData();
  flashStore.setMessage("Conta deletada com sucesso", "success");

  router.push("/");
};

const updateUser = async () => {
  try {
    await userUpdate({
      password: newPassword.value,
      current_password: curPassword.value
    });

    flashStore.setMessage("Senha atualizada com sucesso", "success");
    router.push("/signin");
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
  height: 100%;
}

.app-form {
  display: grid;
  grid-row-gap: 20px;

  @media screen and (min-width: 600px) {
    grid-template-columns: repeat(2, 1fr);
    grid-template-rows: repeat(4, 0.5fr);
    grid-column-gap: 20px;

    & .div1 {
      grid-area: 2 / 1 / 5 / 2;
    }

    & .action-btn {
      height: 100%;
    }
  }
}

.app-card {
  padding: 8px 12px;

  &>h2 {
    margin-bottom: 12px;
  }
}
</style>