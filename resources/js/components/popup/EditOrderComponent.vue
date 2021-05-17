<template>
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content mb-3">
                <div class="card-header"><span>{{ order.client }} {{newStatus.color}}</span>
                   </div>
<!--                <div class="modal-body">-->
                    <div :class="order.color">

                    <h5 class="card-title d-flex w-100 justify-content-between"><span>{{ order.product }} - {{ order.qty }} {{ order.unit }}</span> <span>{{ order.shippingDate }}</span></h5>
<!--                        <div class="form-group">-->
<!--                            <div class="form-check">-->
<!--                                <input class="form-check-input" type="checkbox" value="check" id="isConfirmed"-->
<!--                                       v-model="order.isConfirmed">-->
<!--                                <label class="form-check-label" for="isConfirmed">-->
<!--                                    Подтверждено-->
<!--                                </label>-->
<!--                            </div>-->
<!--                        </div>-->

                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label" for="status">
                                    Статус заявки:
                                </label>
                                <select v-model="newStatus" class="form-control" name="status" id="status" @change="setStatus">
                                    <option v-for="(status, index) in statuses"
                                            :key="index"
                                            :value="status"
                                    ><div>{{ status.status }}</div>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <p class="card-text">{{ order.comment }}</p>
                        <hr>
                        <button type="button" class="btn btn-outline-dark w-100" data-dismiss="modal">Закрыть</button>
                    </div>
<!--                </div>-->

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
            newStatus: {}
        }
    },
    props: {
        order: {}
    },
    methods: {
        ...mapActions([]),
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
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'DATE'
        ]),
        findSelectedProduct() {
            return this.PRODUCTS.find(product => product.id === this.order.product_id)
        }
    },
    mounted() {
        this.getStatuses()
    }
}
</script>

<style scoped>

</style>
