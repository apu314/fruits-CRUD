<template>
  <div class="container">
    <div class="">
      <div>
        <h1>Fruits</h1>

        <fruits-list />

      </div>
      <div class="">
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
    justify-content: center;
    align-items: center;
    text-align: center;

    min-height: 100vh;
    margin: 0 auto;


  }
</style>
