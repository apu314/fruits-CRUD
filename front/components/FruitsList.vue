<template>
  <div class="card">
    <div class="card--header">
      <h1>Fruits</h1>

    </div>
    <table class="table">
      <thead class="table-buttons">
        <tr class="table--row">
          <td></td>
          <td></td>
          <td></td>
          <td>
            <button class="btn new--item" v-on:click="toogleCreate()">{{ btnCreateText }}</button>
          </td>
        </tr>
      </thead>
      <tbody>
      <tr class="table--row" v-show="createMode">
        <td>
          <input type="text" placeholder="Name" v-model="newFruit.name">
        </td>
        <td>
          <input type="text" placeholder="Size" v-model="newFruit.size">
        </td>
        <td>
          <input type="text" placeholder="Color" v-model="newFruit.color">
        </td>
        <td class="btn-group">
          <button class="btn btn-edit" v-on:click="create()">Create</button>
          <button class="btn btn-remove" v-on:click="cancelNew()">Cancel</button>
        </td>
      </tr>
      <tr class="table--row" v-bind="fruits" v-for="(fruit, index) in fruits" :key="fruit.id">
        <td>
          <span class="item">{{index}} - {{ fruit.name }} </span>
        </td>
        <td>
          <span class="item">{{ fruit.fruitDetails[0].size }}</span>
        </td>
        <td>
          <span class="item">{{ fruit.fruitDetails[0].color }}</span>
        </td>
        <td class="btn-group">
          <button class="btn btn-edit" v-on:click="edit()">Edit</button>
          <button class="btn btn-remove" v-on:click="remove(fruit.id)">Remove</button>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data () {
      return {
        createMode: false,
        btnCreateText: 'Create',
        fruits: '',
        newFruit: {
          name: '',
          size: '',
          color: ''
        }
      }
    },
    created () {
      this.$axios.get('fruits')
        .then(response => {
          console.log(response.data)
          this.fruits = response.data
        })
    },
    methods: {
      edit: function (id) {
      },
      remove: function (id) {
        this.$axios.delete(`fruit/${id}`)
          .then(response => {
            console.log(response.data)
            this.fruits.splice(id, 1)
          })
      },
      create: function () {
        this.$axios.post('fruit', {
          name: this.newFruit.name,
          size: this.newFruit.size,
          color: this.newFruit.color
        })
          .then(response => {
            console.log('creado')
            let newFruit = response.data
            this.fruits.push({
              id: newFruit.id,
              name: newFruit.name,
              fruitDetails: [
                {
                  size: newFruit.fruitDetails[0].size,
                  color: newFruit.fruitDetails[0].color
                }
              ]
            })
          })
          .catch(error => {
            console.log(error)
          })
      },
      toogleCreate: function () {
        this.createMode = !this.createMode
        if (this.createMode) {
          this.btnCreateText = 'Cancel'
        } else {
          this.btnCreateText = 'Create'
        }
      }
    }
  }
</script>

<style lang="scss">
  .card {
    display: flex;
    flex-direction: column;


    box-shadow: 9px 9px 9px 0 rgba(108, 141, 194, 0.28), -9px -9px 9px 0 rgba(255, 255, 255, 0.82);
    border-radius: 10px;

    margin: 2em 0;
    padding: 1em;
    width: 80vw;

    .card--header {
      position: relative;
      margin: 1em 0;

      .addBtn {
        position: absolute;
        align-self: center;
        justify-self: end;
      }
    }


  }

  .btn {
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
    outline: none;

    box-shadow: 9px 9px 9px 0 rgba(108, 141, 194, 0.28), -9px -9px 9px 0 rgba(255, 255, 255, 0.82);

    border-radius: 10px;
    border: none;

    background-color: inherit;
    --background-color: inherit;

    color: inherit;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 1rem;

    padding: .5em 1em;

    &:not(:last-child) {
      margin-right: .8em;
    }

    &:active {

    }

    &-sm {

    }

    .new--item {
      position: absolute;
      right: 1em;

      box-shadow: 9px 9px 9px 0 rgba(108, 141, 194, 0.28), -9px -9px 9px 0 rgba(255, 255, 255, 0.82);

      background: transparent;
      color: inherit;

      font-size: 1.3em;

      border: none;
      border-radius: 10px;

      margin-top: 1em;

      line-height: 1.5em;
    }
  }


  .table {
    min-width: 100%;
    padding: 0;
    margin: 0;

    border: 1px solid rgba(255, 255, 255, .6);

    .table--row {
      justify-content: space-between;
      justify-items: center;
      align-items: center;
      padding: 1em 0;

      display: grid;
      grid-template-columns: repeat(3, 1fr) 250px;

      :first-child {
      }

      &:not(:last-child) {
        border-bottom: 1px solid rgba(255, 255, 255, .6);

      }

      .item {
        justify-self: center;

        margin: 0 1em;
      }

    }

    .table-buttons tr.table--row{
      .pull-right {
        order: -1;
      }
    }

  }

  .links {
    padding: 1em;
  }

</style>


