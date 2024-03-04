<template>
  <v-dialog>
    <template #activator="{ props: activatorProps }">
      <slot
        name="activator"
        :props="activatorProps"
      />
    </template>
    <v-card class="container">
      <card-wrapper class="card">
        <h2>Membros do projeto</h2>
        <card-wrapper
          v-for="member, index in members"
          :key="index"
          class="card__member"
        >
          <v-icon
            icon="mdi-account"
            size="large"
          />
          <p>{{ member.name }}</p>
          <v-select
            v-model="member.permission"
            rounded
            hide-details
            density="compact"
            :items="getItems(member)"
            :disabled="!canUpdate(member)"
            @update:model-value="(val: number) => updateMember(member, val)"
          />
          <v-btn
            icon="mdi-account-remove"
            class="text-error"
            variant="text"
            :disabled="member.permission >= 8"
            @click="() => removeMember(member.id)"
          />
        </card-wrapper>
        <v-dialog>
          <template #activator="{ props: addMemberProps }">
            <the-button
              v-bind="addMemberProps"
              prepend-icon="mdi-plus"
              block
              :disabled="userPermission <= 2"
            >
              Adicionar
            </the-button>
          </template>
          <card-wrapper class="card add-member">
            <v-form @submit.prevent="addMember">
              <div>
                <p>Nome de usuário ou e-mail</p>
                <v-text-field
                  v-model="username"
                  placeholder="usuario123"
                />
              </div>
              <the-button
                colorful
                block
                type="submit"
              >
                ADICIONAR
              </the-button>
            </v-form>
          </card-wrapper>
        </v-dialog>
      </card-wrapper>
    </v-card>
  </v-dialog>
</template>

<script setup lang="ts">
import { ProjectUser } from "@/types";
import { ref } from "vue";
import { createMember, updateMember as updateMemberAPI, deleteMember } from "@/api";
import { useAppStore } from "@/store/app";

const store = useAppStore();

const props = defineProps({
  members: {
    type: Array<ProjectUser>,
    required: true
  },
  projectId: {
    type: Number,
    required: true
  }
});

const canUpdate = (member: ProjectUser) => {
  if (member.permission >= 4) return false;

  if (member.id === store.user_id) return false;

  if (userPermission <= 2) return false;

  if (member.permission >= 3 && userPermission <= 3) return false;

  return true;
};

const getItems = (member: ProjectUser) => {
  if (member.permission >= 3) return roles;

  return roles.slice(0,2);
};

const roles = [
  {
    title: "Espectador",
    value: 1
  }, 
  {
    title: "Membro",
    value: 2
  },
  {
    title: "Administrador",
    value: 3
  },
  {
    title: "Dono",
    value: 4
  },
];

const userPermission = props.members.find((i) => i.id === store.user_id)?.permission;
const username = ref("");

const addMember = async () => {
  try {
    await createMember(props.projectId, username.value);
    username.value = "";
  } catch (e) {
    //
  }
};

const updateMember = async (member: ProjectUser, permission: number) => {
  try {
    await updateMemberAPI(props.projectId, member.id, permission);
  } catch (e) {
    //    
  }  
};

const removeMember = async (member: number) => {
  try {
    await deleteMember(3, member);
  } catch (e) {
    //
  }
};

</script>

<style scoped lang="scss">
@import "@/styles/informationCard.scss";

.container {
    max-width: 512px;
    width: 100%;
    margin: 0 auto;
}

.card {
    &__member {
        padding: 20px;

        display: grid;
        grid-template-columns: 48px 0.6fr 0.4fr 40px;

        align-items: center;
        gap: 10px;

        & > * {
            height: 100%;
        }

        & > i {
            background-color: rgb(var(--v-theme-secondary-darken-1));
            width: 40px;
            border-radius: 100%;
        }

        & > p {
            font-weight: bold;
            line-height: 40px;
        }
    }
}

.add-member {
    max-width: 512px;
    width: 100%;
    margin: 0 auto;
}
</style>