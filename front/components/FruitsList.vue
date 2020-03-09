<template>
  <div class="card">
    <div class="card--header">
      <h1>Fruits</h1>

    </div>
    <div class="table-container">
      <table class="table">
        <thead class="table-buttons">
        <tr class="table--row">
          <th>Name</th>
          <th>Size</th>
          <th>Color</th>
          <td>
            <button class="btn new--item" @click="toogleCreate()">{{ btnCreateText }}</button>
          </td>
        </tr>
        </thead>
        <tbody>
        <tr class="table--row" v-show="createMode">
          <td>
            <input type="text" placeholder="Name" v-model="newFruit.name"> {{ newFruit.name }}
          </td>
          <td>
            <input type="text" placeholder="Size" v-model="newFruit.size">
          </td>
          <td>
            <input type="text" placeholder="Color" v-model="newFruit.color">
          </td>
          <td class="btn-group">
            <button class="btn btn-edit" @click="create()">Create</button>
            <button class="btn btn-remove" @click="cancelNew()">X</button>
          </td>
        </tr>
        <tr class="table--row"v-for="(fruit, index) in fruits" :key="fruit.id">
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
            <button class="btn btn-edit" @click="edit(fruit.id, index)">Edit</button>
            <button class="btn btn-sm btn-remove" @click="remove(fruit.id, index)">X</button>
          </td>
        </tr>
        </tbody></table>
    </div>
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
      edit: function (id, index) {
        this.$axios.put(`fruit/${id}`, {
          name: this.fruits[index].name,
          size: this.fruits[index].size,
          color: this.fruits[index].color
        }).then(response => {
          console.log('Editado')
        }).catch(error => {
          console.error(error)
        })
      },
      remove: function (id, fruitIndex) {
        this.$axios.delete(`fruit/${id}`)
          .then(response => {
            console.log('Eliminado')
            this.fruits.splice(fruitIndex)
          })
          .catch(error => {
            console.error(error)
          })
      },
      create: function () {
        this.$axios.post('fruit', {
          name: this.newFruit.name,
          size: this.newFruit.size,
          color: this.newFruit.color
        })
          .then(response => {
            console.log('Creado')
            console.log(response.data)
            let newFruit = response.data
            let fruits = this.fruits
            Array.prototype.push.apply(fruits, newFruit)
            this.fruits = fruits
            console.log(fruits, this.fruits)
          })
          .catch(error => {
            console.error(error)
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


    box-shadow: 6px 6px 6px 0 rgba(108, 141, 194, 0.28), -6px -6px 6px 0 rgba(255, 255, 255, 0.82);
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

    box-shadow: 6px 6px 6px 0 rgba(108, 141, 194, 0.28), -6px -6px 6px 0 rgba(255, 255, 255, 0.82);

    border-radius: 10px;
    border: none;

    background-color: #8c97b4;

    color: white;
    text-decoration: none;
    text-transform: uppercase;
    font-size: 1rem;
    font-weight: bold;

    padding: .5em 1em;

    transition: box-shadow 500ms;

    &:not(:last-child) {
      margin-right: .8em;
    }

    &:hover {
      box-shadow: inset 0.2em 0.2em 6px 0 rgba(108, 141, 194, 0.28), inset -0.2em -0.2em 6px 0 rgba(255, 255, 255, 0.82);
    }

    &:active {
      box-shadow: none;
    }

    &-sm {
      &:hover {
        box-shadow: inset 0.2em 0.2em 6px 0 rgba(108, 141, 194, 0.28), inset -0.2em -0.2em 6px 0 rgba(255, 255, 255, 0.82);
      }
    }

    &-transparent {
      background-color: inherit;
      --background-color: inherit;
      color: inherit;
    }

    &-remove {
      background-color: #c12323;
      color: white;
      font-weight: bold;

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

  .table-container {
    overflow-x: auto;
  }
  .table {
    min-width: 758px;
    width: 100%;
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


