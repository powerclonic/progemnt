<template>
  <v-app-bar extension-height="4" flat>
    <template #prepend>
      <v-container class="pa-0">
        <router-link :to="isAuthenticated ? '/dashboard' : '/'" class="title">
          <progemnt-logo class="title__image" />

          <p class="title__text d-none d-sm-inline">progemnt</p>
        </router-link>
      </v-container>
    </template>
    <template #append>
      <v-container class="pa-0 fluid">
        <v-row v-if="!isAuthenticated" dense>
          <v-col>
            <v-btn-darker size="small" @click="$router.push('/signin')">
              entrar
            </v-btn-darker>
          </v-col>
          <v-col>
            <v-btn size="small" @click="$router.push('/signup')">
              cadastro
            </v-btn>
          </v-col>
        </v-row>
        <v-row v-else dense>
          <v-col>
            <v-btn-darker size="small" @click="$router.push('/dashboard')">
              dashboard
            </v-btn-darker>
          </v-col>
          <v-col>
            <v-btn
              size="small"
              append-icon="mdi-account-circle"
              @click="$router.push('/account')"
            >
              olá, {{ user_name.split(" ")[0] }}
            </v-btn>
          </v-col>
        </v-row>
      </v-container>
    </template>
    <template #extension>
      <v-progress-linear
        v-if="$app.loading"
        indeterminate
        color="primary"
        class="v-sheet__loader"
      />
      <div v-else class="bar-border" />
    </template>
  </v-app-bar>
</template>

<script lang="ts" setup>
import { useAppStore } from "@/store/app";
import { storeToRefs } from "pinia";

const { isAuthenticated, user_name } = storeToRefs(useAppStore());
</script>

<style scoped lang="scss">
.title {
  gap: 8px;
  display: flex;
  align-items: center;
  text-decoration: none;
  color: #fff;

  &__image {
    height: 48px;
  }

  &__text {
    font-weight: bolder;
  }

  @media screen and (min-width: 600px) {
    &__text {
      font-size: 1.5rem;
    }
  }
}

.bar-border {
  height: 4px;
  width: 100vw;
  background-color: rgba(var(--v-theme-primary));
}
</style>
