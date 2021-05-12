<template>
  <div class="wrapper">
    <div class="card mt-4">
      <div class="card-header">
        Заявки и планирование отгрузок
      </div>
      <div class="card-body">
        <component-loader v-if="isLoading"></component-loader>
        <div class="list-group">
          <a href="#"
             class="list-group-item list-group-item-action"
             v-for="order in orders"
             key="order.id"
             :class="{'list-group-item-success' : order.isConfirmed }"
          >
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">{{ order.product }}</h5>
              <span>{{order.qty}} {{order.unit}}</span>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <p class="mb-1">{{order.client}}</p>
              <small>{{order.shippingDate}}</small>
            </div>
            <small>{{order.comment}}</small>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "OrdersComponent",
  data() {
    return {
      isLoading: false,
      orders: [],
    }
  },
  methods: {
    ...mapActions([
      'SET_PROMISE_READY'
    ]),
    getOrders() {
      axios.get('/api/plans/orders', {
        headers: {'Content-Type': 'application/json'}
      })
          .then(response => {
            this.orders = response.data
            this.isLoading = false
            this.SET_PROMISE_READY(true)
            return response.data
          })
          .catch(function (error) {
            console.log(error)
          })
    }
  },
  mounted() {
    this.getOrders()
  }
}
</script>

<style scoped>

</style>
