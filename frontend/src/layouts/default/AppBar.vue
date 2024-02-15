<template>
  <v-app-bar
    scroll-behavior="hide"
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
        <v-btn
          class="buttons__signin"
          size="small"
        >
          login
        </v-btn>
        <v-btn
          class="buttons__signup"
          size="small"
        >
          cadastro
        </v-btn>
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

.buttons {
    &__signin {
        margin-right: 10px;

        color: rgba(var(--v-theme-primary));

        background-color: rgba(var(--v-theme-secondary-darken-2));
    }

    &__signup {
        font-weight: bold;
        color: rgba(var(--v-theme-secondary-darken-2));

        background-color: rgba(var(--v-theme-primary));
    }
}

.bar-border {
    height: 4px;
    width: 100vw;
    background-color:  rgba(var(--v-theme-primary));
}
</style>
