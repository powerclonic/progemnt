<template>
  <v-dialog max-width="512">
    <template #activator="{ props: activatorProps }">
      <slot name="activator" :props="activatorProps" />
    </template>
    <v-card class="container">
      <v-sheet loader class="card">
        <h2>Membros do projeto</h2>
        <v-sheet
          v-for="(member, index) in members"
          :key="index"
          class="card__member"
        >
          <v-icon icon="mdi-account" size="large" />
          <p>{{ member.name }}</p>
          <v-select
            v-model="member.permission"
            class="card__select"
            hide-details
            density="compact"
            :items="getItems(member)"
            :disabled="!canUpdate(member) || store.loading"
            @update:model-value="(val: number) => updateMember(member, val)"
          />
          <v-btn-darker
            icon="mdi-account-remove"
            class="text-error"
            :disabled="!canUpdate(member) || store.loading"
            @click="() => removeMember(member.id, index)"
          />
        </v-sheet>
        <v-dialog v-model="addMemberDialog">
          <template #activator="{ props: addMemberProps }">
            <v-btn-dark
              v-bind="addMemberProps"
              prepend-icon="mdi-plus"
              block
              :disabled="userPermission <= 2"
            >
              Adicionar
            </v-btn-dark>
          </template>
          <v-sheet class="card add-member">
            <v-form @submit.prevent="addMember">
              <div>
                <p>Nome de usuário ou e-mail</p>
                <v-text-field
                  v-model="username"
                  placeholder="usuario123"
                  required
                />
              </div>
              <v-btn block type="submit" :disabled="store.loading">
                ADICIONAR
              </v-btn>
            </v-form>
          </v-sheet>
        </v-dialog>
      </v-sheet>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ProjectUser } from "@/types";
import { ref } from "vue";
import {
  createMember,
  updateMember as updateMemberAPI,
  deleteMember,
} from "@/api";
import { useAppStore } from "@/store/app";
import { useFlashStore } from "@/store/flash";

const store = useAppStore();
const flash = useFlashStore();

const props = defineProps({
  members: {
    type: Array<ProjectUser>,
    required: true,
  },
  projectId: {
    type: Number,
    required: true,
  },
});

const emits = defineEmits(["update:member-removed"]);

const canUpdate = (member: ProjectUser) => {
  if (member.permission >= 4) return false;

  if (member.id === store.user_id) return false;

  if (userPermission <= 2) return false;

  if (member.permission >= 3 && userPermission <= 3) return false;

  return true;
};

const getItems = (member: ProjectUser) => {
  if (member.permission >= 3) return roles;

  if (userPermission >= 4) return roles.slice(0, 3);

  return roles.slice(0, 2);
};

const roles = [
  {
    title: "Espectador",
    value: 1,
  },
  {
    title: "Membro",
    value: 2,
  },
  {
    title: "Administrador",
    value: 3,
  },
  {
    title: "Dono",
    value: 4,
  },
];

const userPermission = props.members.find(
  (i) => i.id === store.user_id,
)?.permission;

const username = ref("");
const addMemberDialog = ref(false);

const addMember = async () => {
  try {
    await createMember(props.projectId, username.value);
    username.value = "";
    addMemberDialog.value = false;
    flash.setMessage("Usuário adicionado ao projeto", "success");
  } catch (e) {
    //
  }
};

const updateMember = async (member: ProjectUser, permission: number) => {
  try {
    await updateMemberAPI(props.projectId, member.id, permission);

    flash.setMessage("Nível de permissão alterado", "success");
  } catch (e) {
    //
  }
};

const removeMember = async (member: number, index: number) => {
  try {
    await deleteMember(props.projectId, member);
    flash.setMessage("Usuário removido do projeto", "success");
    emits("update:member-removed", index);
  } catch (e) {
    //
  }
};
</script>

<style scoped lang="scss">
@import "@/styles/informationCard.scss";

.card {
  &__member {
    padding: 20px 0;

    display: grid;
    grid-template-columns: 48px 1fr 40px;
    grid-template-rows: 1fr 1fr;

    align-items: center;
    gap: 10px;

    & > * {
      height: 100%;
    }

    & > i {
      display: inline-block;
      background-color: rgb(var(--v-theme-secondary-darken-1));
      width: 40px;
      border-radius: 100%;
    }

    & > p {
      font-weight: bold;
      line-height: 40px;

      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }
  }

  &__select {
    grid-area: 2 / 1 / 3 / 4;
  }
}

.add-member {
  max-width: 512px;
  width: 100%;
  margin: 0 auto;
}

@media screen and (min-width: 600px) {
  .card {
    &__member {
      grid-template-columns: 48px 0.6fr 0.4fr 40px;
      grid-template-rows: 1fr;
    }

    &__select {
      grid-area: unset;
    }
  }
}
</style>
