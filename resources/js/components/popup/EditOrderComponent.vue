<template>
    <div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content text-white bg-primary mb-3">
                <div class="card-header d-flex w-100 justify-content-between"><span>{{order.client}}</span> <span>{{order.shippingDate}}</span></div>
                <div class="modal-body">
                    <h5 class="card-title">{{order.product}} - {{ order.qty }} {{ order.unit }}</h5>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="check" id="isConfirmed"
                                   v-model="order.isConfirmed">
                            <label class="form-check-label" for="isConfirmed">
                                Подтверждено
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="check" id="shipped"
                                   v-model="order.isShipped">
                            <label class="form-check-label" for="shipped">
                                Отгружено
                            </label>
                        </div>
                    </div>
                    <p class="card-text">{{order.comment}}</p>

                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Закрыть</button>

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
            isShipped: 0
        }
    },
    props: {
        order: {}
    },
    methods: {
        ...mapActions([]),
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
}
</script>

<style scoped>

</style>
