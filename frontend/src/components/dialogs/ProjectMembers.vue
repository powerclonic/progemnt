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
            rounded
            hide-details
            density="compact"
            size="sm"
            :items="roles"
            :model-value="member.permission"
            :disabled="member.permission >= 4"
          />
          <v-btn
            icon="mdi-account-remove"
            class="text-error"
            variant="text"
            size="lg"
            :disabled="member.permission >= 8"
            @click="removeMember"
          />
        </card-wrapper>
        <v-dialog>
          <template #activator="{ props: addMemberProps }">
            <the-button
              v-bind="addMemberProps"
              prepend-icon="mdi-plus"
              block
            >
              Adicionar
            </the-button>
          </template>
          <card-wrapper class="card add-member">
            <v-form>
              <div>
                <p>Nome de usuário ou e-mail</p>
                <v-text-field />
              </div>
              <the-button
                colorful
                block
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
import { PropType } from "vue";
import { deleteMember } from "@/api";


const props = defineProps({
  members: {
    type: [] as PropType<Array<ProjectUser>>,
    required: true
  }
});

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

const removeMember = async () => {
  await deleteMember(3, "teste");
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