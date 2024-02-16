<template>
  <v-footer class="app-footer">
    <progemnt-logo class="app-footer__image" />
    <div>
      <h3>progemnt</h3>
      <p class="app-footer__link">
        por <a
          href="http://mdresch.com.br"
          target="_blank"
          rel="noopener noreferrer"
        >mdresch.com.br</a>
      </p>
    </div>
  </v-footer>
</template>

<style scoped lang="scss">
.app-footer {
    border-top: 4px solid rgb(var(--v-theme-primary));

    max-height: 5rem;

    &__image {
        height: 64px;
        margin-right: 12px;
    }

    &__link {
        color: rgb(var(--v-theme-secondary));

        & > a {
            color: inherit;
            font-weight: bold;
            text-decoration: none;
        }
    }
}
</style>