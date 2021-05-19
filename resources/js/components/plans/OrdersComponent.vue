<template>
    <div class="wrapper">
        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex w-100 justify-content-between">
                    <span class="mb-1">Заявки</span>
                    <button class="btn btn-outline-primary"
                            type="button"
                            data-toggle="modal"
                            data-target="#newOrderModal"
                            @click="showPopup"
                    >Добавить
                    </button>
                </div>
            </div>
            <div class="card-body">
                <component-loader v-if="isLoading"></component-loader>
                <div class="list-group"
                :key="UPDATE">
                    <div
                        class="list-group-item bg-light"
                        v-for="(order, index) in orders"
                        :key="index"
                    >
                      <div class="modalShow"
                           @click="EditOrder(order)"
                           :class="order.color"
                      >
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">{{ order.product }}</h5>
                            <span>{{ order.qty }} {{ order.unit }}</span>
                        </div>
                        <div class="d-flex w-100 justify-content-between">
                            <p class="mb-1">{{ order.client }}</p>
                            <small>{{ order.shippingDate }}</small>
                        </div>
                      </div>

                      <div class="commentBtn">
                        <button class="btn btn-link" type="button" data-toggle="collapse" :data-target="'#comments'+order.id" aria-expanded="false" :aria-controls="'comments'+order.id">
                            <span >Комментарии </span>
                            <span class="badge badge-primary"> {{order.comments.length}} </span>
                        </button>
                      </div>
                      <div class="collapse" :id="'comments'+order.id">
                        <div class="alert alert-primary"
                        v-for="(comment, index) in order.comments"
                        :key="index">
                          <div class="d-flex w-100 justify-content-between">
                            <small>{{ comment.username }}</small>
                            <small>{{ comment.date }}</small>
                          </div>



                          <div>
                            {{comment.comment}}
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <add-new-order-component
            @sendOrder="addOrder"
        />
        <edit-order-component
            :order="selectedOrder"
        />
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'
import AddNewOrderComponent from "../popup/AddNewOrder";
import EditOrderComponent from "../popup/EditOrderComponent";

export default {
    name: "OrdersComponent",
    components: {EditOrderComponent, AddNewOrderComponent},
    data() {
        return {
            isLoading: false,
            orders: [],
            isPopupVisible: false,
            isEditOrderVisible: false,
            selectedOrder: {}
        }
    },
    computed: {
      ...mapGetters([
      'UPDATE'
      ])
    },
    methods: {
        ...mapActions([
            'SET_PROMISE_READY',
            'UPDATE_KEY'
        ]),
        showPopup() {
            this.isPopupVisible = true
        },
        closePopup() {
            this.isPopupVisible = false
        },
        EditOrder(order) {
          $('#editOrderModal').modal('show')
          // data-toggle="modal"
          // data-target="#editOrderModal"
            this.selectedOrder = order
            this.isPEditOrderVisible = true
        },
        closeEditOrder() {
            this.isEditOrderVisible = false
        },
        getOrders() {
            axios.get('/api/plans/orders', {
                headers: {'Content-Type': 'application/json'}
            })
                .then(response => {
                    this.orders = response.data
                    console.log(response.data)
                    this.isLoading = false
                    this.SET_PROMISE_READY(true)
                    return response.data
                })
                .catch(function (error) {
                    console.log(error)
                })
        },
        addOrder(data) {
            axios.post('/api/plans/orders',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.action()
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        },
        action() {
            this.isLoading = true
            this.SET_PROMISE_READY(false)
            this.closePopup()
            this.UPDATE_KEY()
        },
    },
    mounted() {
        this.getOrders()
    }
}
</script>

<style scoped>
.commentBtn {
  display: block;
  z-index: 2!important;
  position: relative;
}
.modalShow:hover {
  cursor: pointer;

}
</style>
