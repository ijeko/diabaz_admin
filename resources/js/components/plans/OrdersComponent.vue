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
                <div class="d-flex justify-content-center flex-wrap p-1">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  alert-danger" id="allOrders"
                               data-toggle="tab" href="#allOrdersContent" role="tab" aria-controls="allOrdersContent"
                               aria-selected="true">Все ({{ orders.length }})</a>
                        </li>
                        <li class="nav-item" role="presentation"
                            v-for="(status, index) in statuses"
                        >
                            <a class="nav-link" :class="'alert-'+status.color.replace('list-group-item-', '')"
                               :id="'statusID'+index"
                               data-toggle="tab" :href="'#contentID'+index" role="tab"
                               :aria-controls="'contentID'+index"
                               aria-selected="true">{{ status.status }}
                                ({{ filterOrdersByStatus(status.id).length }})</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  alert-danger" id="notPaid"
                               data-toggle="tab" href="#notPaidContent" role="tab" aria-controls="notPaidContent"
                               aria-selected="true">Не оплачено ({{ filterOrdersByPaidShipped('notPaid').length }})</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  alert-warning" id="isPaid"
                               data-toggle="tab" href="#isPaidContent" role="tab" aria-controls="isPaidContent"
                               aria-selected="true">Предоплачено ({{ filterOrdersByPaidShipped('isPaid').length }})</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link  alert-success" id="isShipped"
                               data-toggle="tab" href="#isShippedContent" role="tab" aria-controls="isShippedContent"
                               aria-selected="true">Отгружено ({{ filterOrdersByPaidShipped('isShipped').length }})</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <component-loader v-if="isLoading"></component-loader>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade"
                         id="allOrdersContent"
                         role="tabpanel"
                         aria-labelledby="allOrders"
                    >
                        <div class="list-group">
                            <div
                                class="list-group-item bg-light"
                                v-for="(order, index) in getOrders"
                                :key="UPDATE"

                            >
                                <div class="modalShow"
                                     @click="EditOrder(order)"
                                     :class="'alert alert-'+order.color.replace('list-group-item-', '')"
                                     data-toggle="modal"
                                     data-target="#editOrderModal"
                                >
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ order.product }}
                                            <span class="badge badge-pill badge-success"
                                                  v-if="order.isPaid && !order.isShipped">Оплачен</span>
                                            <span class="badge badge-pill badge-warning"
                                                  v-if="!order.isPaid && order.isShipped">Не оплачен</span>
                                            <span class="badge badge-pill badge-primary"
                                                  v-if="order.isPaid && order.isShipped">Отгружен</span>
                                        </h5>
                                        <span>{{ order.qty }} {{ order.unit }}</span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ order.client }}</p>
                                        <small>{{ order.shippingDate }}</small>
                                    </div>
                                </div>

                                <div class="commentBtn">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            :data-target="'#comments'+order.id" aria-expanded="false"
                                            :aria-controls="'comments'+order.id">
                                        <span>Комментарии </span>
                                        <span class="badge badge-primary"> {{ order.comments.length }} </span>
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
                                            {{ comment.comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         :class="{'show active': index==0 }"
                         v-for="(status, index) in statuses"
                         :id="'contentID'+index"
                         role="tabpanel"
                         :aria-labelledby="'statusID'+index"
                    >
                        <div class="list-group">
                            <div
                                class="list-group-item bg-light"
                                v-for="(order, index) in filterOrdersByStatus(status.id)"
                                :key="UPDATE"

                            >
                                <div class="modalShow"
                                     @click="EditOrder(order)"
                                     :class="'alert alert-'+order.color.replace('list-group-item-', '')"
                                     data-toggle="modal"
                                     data-target="#editOrderModal"
                                >
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ order.product }}
                                            <span class="badge badge-pill badge-success"
                                                  v-if="order.isPaid && !order.isShipped">Оплачен</span>
                                            <span class="badge badge-pill badge-warning"
                                                  v-if="!order.isPaid && order.isShipped">Не оплачен</span>
                                            <span class="badge badge-pill badge-primary"
                                                  v-if="order.isPaid && order.isShipped">Отгружен</span>
                                        </h5>
                                        <span>{{ order.qty }} {{ order.unit }}</span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ order.client }}</p>
                                        <small>{{ order.shippingDate }}</small>
                                    </div>
                                </div>

                                <div class="commentBtn">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            :data-target="'#comments'+order.id" aria-expanded="false"
                                            :aria-controls="'comments'+order.id">
                                        <span>Комментарии </span>
                                        <span class="badge badge-primary"> {{ order.comments.length }} </span>
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
                                            {{ comment.comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="isShippedContent"
                         role="tabpanel"
                         aria-labelledby="isShipped"
                    >
                        <div class="list-group">
                            <div
                                class="list-group-item bg-light"
                                v-for="(order, index) in filterOrdersByPaidShipped('isShipped')"
                                :key="UPDATE"

                            >
                                <div class="modalShow"
                                     @click="EditOrder(order)"
                                     :class="'alert alert-'+order.color.replace('list-group-item-', '')"
                                     data-toggle="modal"
                                     data-target="#editOrderModal"
                                >
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ order.product }}
                                            <span class="badge badge-pill badge-success"
                                                  v-if="order.isPaid && !order.isShipped">Оплачен</span>
                                            <span class="badge badge-pill badge-warning"
                                                  v-if="!order.isPaid && order.isShipped">Не оплачен</span>
                                            <span class="badge badge-pill badge-primary"
                                                  v-if="order.isPaid && order.isShipped">Отгружен</span>
                                        </h5>
                                        <span>{{ order.qty }} {{ order.unit }}</span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ order.client }}</p>
                                        <small>{{ order.shippingDate }}</small>
                                    </div>
                                </div>

                                <div class="commentBtn">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            :data-target="'#comments'+order.id" aria-expanded="false"
                                            :aria-controls="'comments'+order.id">
                                        <span>Комментарии </span>
                                        <span class="badge badge-primary"> {{ order.comments.length }} </span>
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
                                            {{ comment.comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="isPaidContent"
                         role="tabpanel"
                         aria-labelledby="isPaid"
                    >
                        <div class="list-group">
                            <div
                                class="list-group-item bg-light"
                                v-for="(order, index) in filterOrdersByPaidShipped('isPaid')"
                                :key="UPDATE"

                            >
                                <div class="modalShow"
                                     @click="EditOrder(order)"
                                     :class="'alert alert-'+order.color.replace('list-group-item-', '')"
                                     data-toggle="modal"
                                     data-target="#editOrderModal"
                                >
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ order.product }}
                                            <span class="badge badge-pill badge-success"
                                                  v-if="order.isPaid && !order.isShipped">Оплачен</span>
                                            <span class="badge badge-pill badge-warning"
                                                  v-if="!order.isPaid && order.isShipped">Не оплачен</span>
                                            <span class="badge badge-pill badge-primary"
                                                  v-if="order.isPaid && order.isShipped">Отгружен</span>
                                        </h5>
                                        <span>{{ order.qty }} {{ order.unit }}</span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ order.client }}</p>
                                        <small>{{ order.shippingDate }}</small>
                                    </div>
                                </div>

                                <div class="commentBtn">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            :data-target="'#comments'+order.id" aria-expanded="false"
                                            :aria-controls="'comments'+order.id">
                                        <span>Комментарии </span>
                                        <span class="badge badge-primary"> {{ order.comments.length }} </span>
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
                                            {{ comment.comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade"
                         id="notPaidContent"
                         role="tabpanel"
                         aria-labelledby="notPaid"
                    >
                        <div class="list-group">
                            <div
                                class="list-group-item bg-light"
                                v-for="(order, index) in filterOrdersByPaidShipped('notPaid')"
                                :key="UPDATE"

                            >
                                <div class="modalShow"
                                     @click="EditOrder(order)"
                                     :class="'alert alert-'+order.color.replace('list-group-item-', '')"
                                     data-toggle="modal"
                                     data-target="#editOrderModal"
                                >
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">{{ order.product }}
                                            <span class="badge badge-pill badge-success"
                                                  v-if="order.isPaid && !order.isShipped">Оплачен</span>
                                            <span class="badge badge-pill badge-warning"
                                                  v-if="!order.isPaid && order.isShipped">Не оплачен</span>
                                            <span class="badge badge-pill badge-primary"
                                                  v-if="order.isPaid && order.isShipped">Отгружен</span>
                                        </h5>
                                        <span>{{ order.qty }} {{ order.unit }}</span>
                                    </div>
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1">{{ order.client }}</p>
                                        <small>{{ order.shippingDate }}</small>
                                    </div>
                                </div>

                                <div class="commentBtn">
                                    <button class="btn btn-link" type="button" data-toggle="collapse"
                                            :data-target="'#comments'+order.id" aria-expanded="false"
                                            :aria-controls="'comments'+order.id">
                                        <span>Комментарии </span>
                                        <span class="badge badge-primary"> {{ order.comments.length }} </span>
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
                                            {{ comment.comment }}
                                        </div>
                                    </div>
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
            v-if="isEditOrderVisible"
            :order="selectedOrder"
            @closeEditOrder="closeEditOrder"
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
            selectedOrder: {},
            statuses: [],
            filters: {}
        }
    },
    computed: {
        ...mapGetters([
            'UPDATE'
        ]),
    },
    methods: {
        ...mapActions([
            'SET_PROMISE_READY',
            'UPDATE_KEY'
        ]),
        filterOrdersByStatus(id) {
            let filteredOrders = this.orders.filter(function (val) {
                if (!val.isPaid && !val.isShipped) {
                    return val.status == id;
                }
            })
            return filteredOrders

        },
        filterOrdersByPaidShipped(status) {
            if (status == 'notPaid') {
                let filteredOrders = this.orders.filter(function (val) {
                    if (val.isShipped && !val.isPaid)
                        return val
                })
                return filteredOrders
            }
            if (status == 'isPaid') {
                let filteredOrders = this.orders.filter(function (val) {
                    if (!val.isShipped && val.isPaid)
                        return val
                })
                return filteredOrders
            }
            if (status == 'isShipped') {
                let filteredOrders = this.orders.filter(function (val) {
                    if (val.isShipped && val.isPaid)
                        return val
                })
                return filteredOrders
            }
        },
        showPopup() {
            this.isPopupVisible = true
        },
        closePopup() {
            this.isPopupVisible = false
        },
        EditOrder(order) {
            // $('#editOrderModal').modal('show')
            // data-toggle="modal"
            // data-target="#editOrderModal"
            this.selectedOrder = order
            this.isEditOrderVisible = true
        },
        closeEditOrder() {
            this.selectedOrder = {}
            this.isEditOrderVisible = false
        },
        getOrderStatuses() {
            axios.get('/api/admin/status',
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.statuses = response.data
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        },
        getOrders() {
            let data = JSON.stringify(this.filters)
            axios.get('/api/plans/orders', {
                headers: {'Content-Type': 'application/json'},
                params: {data: data}
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
        this.getOrderStatuses()
    }
}
</script>

<style scoped>
.commentBtn {
    display: block;
    z-index: 2 !important;
    position: relative;
}

.modalShow:hover {
    cursor: pointer;

}
</style>
