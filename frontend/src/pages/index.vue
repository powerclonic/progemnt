<template>
  <v-container class="app-body">
    <card-wrapper class="home-card">
      <h2>Já precisou organizar suas tarefas?</h2>
      <p>
        Deve ter percebido que isso pode não ser uma tarefa muito 
        fácil.
      </p>
      <p>Mas não se preocupe, o Progemnt está aqui para te ajudar.</p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Seja para projetos individuais ou em equipe</h2>
      <p>
        O progemnt oferece uma ampla gama de recursos para que você possa escalonar seu projeto para diferentes tamanhos de equipes, seja ela de 1 ou 50 pessoas.
      </p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>O que está esperando?</h2>
      <p>
        Com alguns simples cliques você fará parte disso, junto conosco.
      </p>
      <the-button
        block
        flat
        lighter
        @click="$router.push('/signin')"
      >
        quero me cadastrar
      </the-button>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Os recursos do Progemnt</h2>
      <p>
        Temos uma variedade de recursos para os mais variados tipos de necessidades quando se trata de organização de tarefas, desde o status de cada uma delas como prazos e responsáveis pelas mesmas.
      </p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Sem custos</h2>
      <p>
        Hoje em dia quase todos sistemas de gerenciamento de tarefas que conhecemos bloqueiam a maioria dos recursos atrás de assinaturas, mas aqui não funciona assim, todos recursos são gratuitos.
      </p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Simples e intuitivo</h2>
      <p>
        O Progemnt foi feito para todos. Sendo assim, nos esforçamos ao máximo para termos uma interface simples e elegante, de forma que todos possam usar o aplicativo sem maiores dificuldades.
      </p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Aqui você tem voz</h2>
      <p>
        Aqui o cliente tem sempre a razão, por isso garantimos uma boa transparência e escutamos todos os seus retornos! Deste modo criamos um ambiente que está sempre em evolução e melhorando cada vez mais.
      </p>
    </card-wrapper>
    <card-wrapper class="home-card">
      <h2>Isso é o progemnt</h2>
      <p>
        Um aplicativo open-source, desenvolvido puramente para melhorar minhas habilidades, mas mesmo que seja apenas um projeto de teste, fique livre para desfrutá-lo!
      </p>
    </card-wrapper>
  </v-container>
</template>

<script lang="ts" setup>
  //
</script>

<style scoped lang="scss">
.home-card {
    margin-bottom: 16px;
    padding: 8px 12px;

    display: grid;
}

.app-body {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        grid-template-rows: repeat(8, 1fr);

        height: 100%;
    }

@media screen and (min-width: 600px) {
    .app-body {
        grid-template-columns: repeat(2, 1fr);
        grid-template-rows: repeat(4, 1fr);
        grid-column-gap: 20px;
    }
}

</style>