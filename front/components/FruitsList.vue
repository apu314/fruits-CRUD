<template>
  <div class="card">
    <ul>
      <li class="list--item" v-for="fruit in fruits">
        <div>{{ fruit.name }}</div>
        <div>{{ fruit.fruit_details[0].size }}</div>
        <div>{{ fruit.fruit_details[0].color }}</div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        fruits: ''
      }
    },
    created () {
      this.$axios.get('fruits')
        .then(response => {
          this.fruits = response.data
        })
    }
  }
</script>

<style lang="scss">
</style>


