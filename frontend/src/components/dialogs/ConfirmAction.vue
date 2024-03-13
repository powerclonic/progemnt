<template>
  <v-dialog
    v-model="isActive"
    max-width="512"
    transition="dialog-bottom-transition"
  >
    <template #activator="{ props: activatorProps }">
      <slot name="activator" :props="activatorProps" />
    </template>
    <v-card>
      <v-card-title>Tem certeza?</v-card-title>
      <v-card-subtitle>Esta ação é irreversível.</v-card-subtitle>
      <v-card-text>
        <v-spacer />
      </v-card-text>
      <v-card-actions>
        <v-row no-gutters>
          <v-col>
            <v-btn-dark :disabled="loading" block @click="$emit('confirm')">
              Confirmar
            </v-btn-dark>
          </v-col>
          <v-col>
            <v-spacer />
          </v-col>
          <v-col>
            <v-btn block :disabled="loading" @click="isActive = false">
              Cancelar
            </v-btn>
          </v-col>
        </v-row>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { useAppStore } from "@/store/app";
import { storeToRefs } from "pinia";

const { loading } = storeToRefs(useAppStore());

const isActive = ref(false);

defineEmits(["confirm"]);
</script>
