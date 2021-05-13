<template>
    <div class="modal fade" id="newOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Новая заявка</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="product">Требуемая продукция</label>
                        <select v-model="selectedProduct" name="product" id="product" class="form-control">
                            <option
                                v-for="(product, index) in PRODUCTS"
                                :value="product"
                            >{{ product.title }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="qty">Количество, {{ selectedProduct.unit }}</label>
                        <input v-model="qty" class="form-control" type="number" id="qty">
                    </div>

                    <div class="form-group">
                        <label for="client">Клиент</label>
                        <input v-model="client" type="text" name="client" id="client" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="date">Дата отгрузки</label>
                        <input v-model="shippingDate" type="date" class="form-control" id="date">
                    </div>

                    <div class="form-group">
                        <label for="comment">Комментарии</label>
                        <textarea v-model="comment" type="text" name="client" id="comment" class="form-control">&nbsp;</textarea>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="check" id="confirmation" v-model="isConfirmed">
                            <label class="form-check-label" for="confirmation">
                                Подтверждено
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                            @click="sendOrder"
                            data-dismiss="modal"
                            :disabled="!isSelectedAndNoZero"
                    >Добавить</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>

                </div>
            </div>
        </div>
    </div>


</template>

<script>
import { mapGetters, mapActions} from 'vuex'
export default {
    name: "AddNewOrderComponent",
    props: {
        user: {}
    },
    mounted() {
        this.GET_PRODUCTS({currentDate: this.DATE})
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        closePopup() {
            this.$emit('closePopup')
        },
        sendOrder() {
            var data = {
                product_id: this.selectedProduct.id,
                qty: this.qty,
                shippingDate: this.shippingDate,
                client: this.client,
                comment: this.comment,
                isConfirmed: this.isConfirmed,
                isSuccess: 0
            }
                this.$emit('sendOrder', data)
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'DATE'
        ]),
        isSelectedAndNoZero() {
            return !!(this.selectedProduct && this.qty > 0 && this.client);
        }
    },
    data() {
        return {
            qty: 0,
            selectedProduct: {},
            client: '',
            comment: '',
            shippingDate: new Date().toISOString().slice(0, 10),
            message: '',
            isConfirmed: 0
        }
    }
}
</script>

<style scoped>
.body {
    padding: 10px;
    background-color: #cbd5e0;
    width: 400px;
    height: auto;
    position: absolute;
    left: 60px;
    top: 30%;
    z-index: 1;
    border-radius: 5px;
}

.btn {
    width: 100%;
}
</style>
