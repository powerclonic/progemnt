<template>
  <v-container class="app-body">
    <card-wrapper class="app-form">
      <v-form
        v-model="form"
        validate-on="input"
        class="app-form__container"
        @submit.prevent="sendForm"
      >
        <h1>Bem-vindo(a) de volta!</h1>
        <p class="mb-2">
          Para continuar, informe suas credenciais
        </p>
        <flash-message />
        <v-text-field
          v-model="identifier"
          label="e-mail ou nome de usuário"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
          type="email"
          autocomplete="current-username"
          :rules="[rules.required]"
        />
        <v-text-field
          v-model="password"
          label="senha"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          rounded="lg"
          type="password"
          autocomplete="current-password"
          :rules="[rules.required]"
        />
        <the-button
          colorful
          flat
          block
          type="submit"
          :disabled="!form || store.loading"
          :loading="store.loading"
        >
          entrar
        </the-button>
      </v-form>
    </card-wrapper>
  </v-container>
</template>

<script setup lang="ts">
import { signIn } from "@/api";
import { ref } from "vue";
import {useAppStore} from "@/store/app";
import { useRouter } from "vue-router/auto";

const store = useAppStore();
const router = useRouter();

const form = ref(false);
const identifier = ref("");
const password = ref("");

const rules = {
  required: (value: any) => !!value || "Obrigatório",
  maxLength: (value: any) => value.length > 512 || "Número máximo de caracteres atingido"
};

const sendForm = async () => {
  try {
    const res = await signIn(identifier.value, password.value, false);
    store.setAuthData(res.data);

    router.push("/account");
  } catch (error) {
    //
  }
};
</script>

<style scoped lang="scss">
.app-body {
    display: grid;
    height: 100%;
}

.app-form {
    display: grid;
    align-items: center;
    justify-items: center;

    padding: 0 8px;

    &__container {
        text-align: center;
        max-width: 512px;
        width: 100%;

        & .v-input {
            text-align: left;
            margin-bottom: 8px;
        }
    }
}
</style>