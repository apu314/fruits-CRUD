<template>
  <div class="container">
        <fruits-list/>
      <div class="links">
        <a
          href="https://nuxtjs.org/"
          target="_blank"
          class="button--green"
        >
          Documentation
        </a>
        <a
          href="https://github.com/nuxt/nuxt.js"
          target="_blank"
          class="button--grey"
        >
          GitHub
        </a>
      </div>
  </div>
</template>

<script>
  import FruitsList from '~/components/FruitsList.vue'


  export default {
    components: {
      FruitsList
    }

  }
</script>

<style>
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;

    min-height: 100vh;
    margin: 0 auto;


  }
</style>
