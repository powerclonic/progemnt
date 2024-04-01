<template>
  <v-container class="app-body">
    <v-sheet class="app-form">
      <v-form
        v-model="form"
        validate-on="input"
        class="app-form__container"
        @submit.prevent="sendForm"
      >
        <h1>Bem-vindo(a)!</h1>
        <p class="mb-2">Para começar, nos informe alguns dados básicos</p>
        <v-text-field
          v-model="name"
          label="nome completo"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="text"
          autocomplete="name"
          :rules="[rules.required, rules.nameFormat, rules.nameLength]"
        />
        <v-text-field
          v-model="username"
          label="nome de usuário"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="text"
          autocomplete="name"
          :rules="[rules.required, rules.usernameFormat, rules.usernameLength]"
        />
        <v-text-field
          v-model="email"
          label="e-mail"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="email"
          autocomplete="name"
          :rules="[rules.required, rules.emailFormat, rules.maxLength]"
        />
        <v-text-field
          v-model="password"
          label="senha"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="password"
          autocomplete="current-password"
          :rules="[rules.required, rules.passwordFormat]"
        />
        <v-text-field
          v-model="confirmPassword"
          label="confirmar senha"
          variant="solo-filled"
          bg-color="secondary-darken-1"
          type="password"
          :rules="[rules.required, rules.equal]"
        />
        <v-btn flat block type="submit" :disabled="!form || store.loading">
          cadastrar
        </v-btn>
      </v-form>
    </v-sheet>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { useAppStore } from "@/store/app";
import { signUp } from "@/api";
import { useRouter } from "vue-router/auto";
import { useFlashStore } from "@/store/flash";

const store = useAppStore();
const router = useRouter();
const flashStore = useFlashStore();

const form = ref(false);
const name = ref("");
const email = ref("");
const password = ref("");
const username = ref("");
const confirmPassword = ref("");

const nameRegExp = /^[a-zA-Z\u00C0-\u00FF]+(?:\s+[a-zA-Z\u00C0-\u00FF]+)*$/;
const emailRegExp =
  /^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/;
const usernameRegExp = /^[a-zA-Z0-9_]+$/;
const passwordRegexp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z])\S{8,}$/;

const rules = {
  required: (value: any) => !!value || "Obrigatório",
  maxLength: (value: any) =>
    value.length <= 512 || "Número máximo de caracteres atingido",

  usernameFormat: (value: any) =>
    !!usernameRegExp.exec(value) ||
    "O nome de usuário eve conter apenas letras, números e underscores",
  usernameLength: (value: any) =>
    requiredLength(value, 3, 16, "nome de usuário"),

  nameFormat: (value: any) =>
    !!nameRegExp.exec(value) ||
    "O nome deve conter apenas letras e não pode começar nem terminar com espaços",
  nameLength: (value: any) => requiredLength(value, 3, 128, "nome"),

  emailFormat: (value: any) =>
    !!emailRegExp.exec(value) || "Formato de e-mail inválido",

  passwordFormat: (value: any) =>
    !!passwordRegexp.exec(value) ||
    "A senha deve ter no mínimo 8 caracteres e conter letras maiúsculas e minúsculas, números e caracteres especiais.",

  equal: (value: any) => value === password.value || "As senhas não são iguais",
};

const requiredLength = (
  value: string,
  min: number,
  max: number,
  field: string,
) =>
  (value.length >= min && value.length <= max) ||
  `O ${field} deve ter no mínimo ${min} e no máximo ${max} caracteres`;

const sendForm = async () => {
  try {
    await signUp({
      name: name.value,
      username: username.value,
      email: email.value,
      password: password.value,
    });

    flashStore.setMessage(
      "Cadastro concluído, você já pode iniciar sua sessão.",
      "success",
    );

    router.push("/signin");
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
