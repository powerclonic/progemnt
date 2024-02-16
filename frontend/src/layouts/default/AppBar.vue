<template>
  <v-app-bar
    extension-height="4"
    flat
  >
    <template #prepend>
      <div class="title">
        <progemnt-logo class="title__image" />
          
        <p class="title__text">
          progemnt
        </p>
      </div>
    </template>
    <template #append>
      <div
        v-if="true"
        class="app-bar__buttons"
      >
        <the-button
          size="small"
          @click="$router.push('/signin')"
        >
          entrar
        </the-button>
        <the-button
          class="ms-2"
          size="small"
          colorful
          @click="$router.push('/signup')"
        >
          cadastro
        </the-button>
      </div>
      <div
        v-else
        class="app-bar__buttons"
      >
        <div>todo</div>
      </div>
    </template>
    <template #extension>
      <div class="bar-border" />
    </template>
  </v-app-bar>
</template>

<script lang="ts" setup>
  //
</script>

<style scoped lang="scss">

.title {
    gap: 8px;
    display: flex;
    align-items: center;

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
    background-color:  rgba(var(--v-theme-primary));
}
</style>
