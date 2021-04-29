<template>
  <div class="card">
    <div class="card-header">Произведенная продукция за {{ FORMATED_DATE.ofMonth }}
      {{ FORMATED_DATE.year }} --- {{ UPDATE }}
    </div>
    <div v-if="message" class="alert alert-danger" role="alert">
      {{ message.error }}
      <div v-for="(item, index) in message.data"
           :key="index"
      >
        {{ item.title }} - {{ item.qty }} {{ item.unit }}
      </div>
    </div>
    <div class="card-body ">
      <div class="list-group">
        <div
            class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
          <span class="w-25 text-left">Продукция</span>
          <span class="w-25 text-center">Произведено</span>
          <span class="w-25 text-center">Отгружено</span>
          <span class="w-25 text-center">Остатки</span>
        </div>
      </div>
      <div class="list-group overflow-auto mat">
        <a href="#"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
           :class="{'text-secondary' : !product.stock, 'list-group-item-success' : product.monthlyProduction}"
           v-for="(product, index) in products"
           :key="index"
        >
          <span class="w-25 text-left">{{ product.title }}</span>
          <span class="w-25 text-center">{{ product.monthlyProduction }} {{ product.unit }}</span>
          <span class="w-25 text-center">{{ product.monthlySold }} {{ product.unit }}</span>
          <span class="w-25 text-center">{{ product.stock }} {{ product.unit }}</span>
        </a>
      </div>
    </div>
    <component-loader v-if="isLoading"></component-loader>
    <enter-produced
        v-if="isEnterVisible"
        class="popup"
        :user="user"
        @closePopup="closePopup"
        @sendProduced="sendProduced"
        @sendSpoiled="sendSpoiled"
    ></enter-produced>
    <enter-sold
        v-if="isSoldVisible"
        class="popup"
        :user="user"
        @closeSold="closeSold"
        @sendSold="sendSold"
    ></enter-sold>
    <div class="btn-group-vertical" role="group" aria-label="Basic example">
      <button type="button"
              class="btn btn-outline-primary"
              data-toggle="modal"
              data-target="#exampleModal"
              @click="showPopup"
      >Добавить производство
      </button>
      <button v-if="user.role != 'gorny'"
              class="btn btn-outline-primary"
              data-toggle="modal"
              data-target="#sold"
              @click="showSold"
      >Добавить отгрузку
      </button>
    </div>
  </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
  name: 'ProductionComponent',
  components: {},
  mounted() {
    // alert('a')
    // this.GET_SOLD(this.date)
    // this.action()
    this.GET_PRODUCTS().then(res => {
      this.isLoading = false
      this.products = this.PRODUCTS

    })
  },
  data: function () {
    return {
      products: this.PRODUCTS,
      isEnterVisible: '',
      isSoldVisible: false,
      message: '',
      errorProduced: '',
      isLoading: true
    }
  },
  // watch: {
  //     // эта функция запускается при любом изменении вопроса
  //     DATE: function (newcurrentDate, oldcurrentDate) {
  //         this.action()
  //     }
  // },
  props: {
    user: {
      default: {}
    },
    date: ''

  },
  computed: {
    ...mapGetters([
      `PRODUCTS`,
      `DATE`,
      'FORMATED_DATE',
      'UPDATE'
    ]),
  },
  methods: {
    ...mapActions([
      'GET_PRODUCTS',
      'GET_MATERIAL_QTY',
      'ADD_SOLD',
      'ADD_PRODUCED',
      'UPDATE_KEY',
      'SET_PROMISE_READY'
    ]),
    showPopup() {
      this.isEnterVisible = true
    },
    closePopup() {
      this.isEnterVisible = ''
    },
    showSold() {
      this.isSoldVisible = true
    },
    closeSold() {
      this.isSoldVisible = ''
    },
    action() {
      this.isLoading = true
      this.SET_PROMISE_READY(false)
      this.closePopup()
      this.closeSold()
      this.UPDATE_KEY()
      return this.GET_PRODUCTS().then(res => {
        this.isLoading = false
        this.SET_PROMISE_READY(true)
      })
    },
    sendProduced(data) {
      // data = JSON.stringify(data)
      axios.post('/api/produced/add',
          {data},
          {
            headers: {'Content-Type': 'application/json'}
          })
          .then(response => {
            // commit('SET_PRODUCED', response.data)
            // this.message = response.data
            this.action()
            return response.data
          })
          .catch(error => {
            if (error.response) {
              this.message = error.response.data.errors
            }
            return error
          })

    },
    sendSpoiled(data) {
      data = JSON.stringify(data)
      axios.post('/api/products/spoiled/',
          {data},
          {
            headers: {'Content-Type': 'application/json'}
          })
          .then(response => {
            // commit('SET_PRODUCED', response.data)
            this.message = response.data
            this.action()
            return response.data
          })
          .catch(error => {
            if (error.response) {
              this.message = error.response.data.errors
            }
            return error
          })

    },
    sendSold(data) {
      data = JSON.stringify(data)
      axios.post('/api/products/sold',
          {data},
          {
            headers: {'Content-Type': 'application/json'}
          })
          .then(response => {
            this.message = response.data
            this.action()
            return response.data
          })
          .catch(error => {
            if (error.response) {
              this.message = error.response.data.errors
            }
            return error
          })
    }
  }
}
</script>
<style scoped>
/*table {*/
/*    width: 100%;*/
/*}*/

/*tr {*/
/*    !*display: flex;*!*/
/*    !*justify-content: space-between;*!*/
/*    border-bottom: 1px dotted silver;*/
/*}*/

/*td {*/
/*    width: 25%;*/
/*}*/

/*td {*/
/*    width: 25%;*/
/*}*/
.mat {
  height: 400px;
}
</style>
