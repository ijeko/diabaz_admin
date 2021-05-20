<template>
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content mb-3">
                <div class="card-header"><span>{{ order.client }} {{ newStatus.color }}</span>
                </div>
                <div :class="order.color">
                    <h5 class="card-title d-flex w-100 justify-content-between"><span>{{ order.product }} - {{order.qty }} {{ order.unit }}</span> <span>{{ order.shippingDate }}</span></h5>
                    <div class="form-group">

                        <label class="form-check-label" for="status">
                            Статус заявки:
                        </label>
                        <select v-model="findCurrentStatus" class="form-control" name="status" id="status"
                                @change="setStatus">
                            <option v-for="(status, index) in statuses"
                                    :key="index"
                                    :value="status"
                                    :class="status.color"
                            >
                                <div>{{ status.status }}</div>
                            </option>
                        </select>

                    </div>
                    <hr>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Введите комментарий"
                               aria-label="Recipient's username" aria-describedby="button-addon2"
                               v-model="newComment">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="button-addon2"
                                    @click="addComment()">ОК
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-dark w-100" data-dismiss="modal" @click="action()">
                        Закрыть
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "EditOrderComponent",
    data() {
        return {
            shippingDate: new Date().toISOString().slice(0, 10),
            message: '',
            isConfirmed: 0,
            statuses: [],
            newStatus: {},
            newComment: ''
        }
    },
    props: {
        order : {
            type: Object,
            default: {}
        }
    },
    methods: {
        ...mapActions([
            'UPDATE_KEY'
        ]),
        action() {
            this.UPDATE_KEY()
            this.$emit('closeEditOrder')
        },
        getStatuses() {
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
        sendStatus() {
            let data = {id: this.order.id, status: this.newStatus.id}
            axios.put('/api/plans/orders',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        },
        setStatus() {
            this.order.color = this.newStatus.color
            this.sendStatus()
        },
        addComment() {
            let data = {order_id: this.order.id, comment: this.newComment}
            axios.post('/api/plans/orders/comment',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.newComment = ''
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'DATE'
        ]),
        findSelectedProduct() {
            return this.PRODUCTS.find(product => product.id === this.order.product_id)
        },
        findCurrentStatus :
        {
           get: function () {
               return this.statuses.find(status => {
                   return status.id === parseInt(this.order.status)
               })
           },
            set: function (newValue) {
               this.newStatus = newValue
            }
        }
    },
    mounted() {
        this.getStatuses()
    }
}
</script>

<style scoped>

</style>
