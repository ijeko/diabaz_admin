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
                <div class="list-group">
                    <div
                        @click="EditOrder(order)"
                        data-toggle="modal"
                        data-target="#editOrderModal"
                        class="list-group-item-action"
                        v-for="(order, index) in orders"
                        :key="index"
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
                        <div class="list-group w-50"
                        v-if="order.comments">
                            <a href="#" class="list-group-item list-group-item-action active"
                            v-for="(comment, index) in order.comments"
                            :key="index">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">{{comment.username}}</h5>
                                    <small>{{comment.date}}</small>
                                </div>
                                <p class="mb-1">{{comment.comment}}</p>
                              <hr>
                            </a>
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
        editOrder() {
            alert('asd')
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

</style>
