<template>
  <v-main>
    <router-view />
    <flash-message />
  </v-main>
</template>

<script lang="ts" setup>
//
</script>

<style>

.v-overlay__scrim {
    backdrop-filter: blur(2px);
}

</style>