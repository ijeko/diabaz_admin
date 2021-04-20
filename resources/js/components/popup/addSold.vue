<template>
    <div class="modal fade" id="sold" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Ввод отгруженной продкции</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div v-if="message" class="alert alert-danger" role="alert">
                        {{ message }}
                    </div>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="date">Дата:</label>
                        <input v-model="inputDate" type="date" class="form-control" id="date">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                                   value="0"
                                   v-model="isMaterial"
                                   checked>
                            <label class="form-check-label" for="exampleRadios1">
                                Продукция
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                                   value="1"
                                   v-model="isMaterial">
                            <label class="form-check-label" for="exampleRadios2">
                                Материалы
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product">Отгружаемая продукция:</label>
                        <select v-model="toSold" name="product" id="product" class="form-control">
                            <option value="" disabled>...</option>
                            <option
                                :value="product"
                                v-for="(product, index) in selectProduction"
                            >{{ product.title }}
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="qty">Количество, {{ toSold.unit }}</label>
                        <input v-model="qty" class="form-control" type="number" id="qty">
                    </div>
                    <div class="form-group">
                        <label for="soldTo">Кому:</label>
                        <input v-model="soldTo" class="form-control" type="text" id="soldTo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary"
                            @click="sendSold"
                            data-dismiss="modal"
                            :disabled="!isSelectedAndNoZero"
                    >Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'

export default {
    name: "popup",
    props: {
        user: {}

    },
    methods: {
        closeSold() {
            this.$emit('closeSold')
        },
        sendSold() {
            if (this.qty <= 0) {
                this.message = 'Количество должно быть больше 0'
                return false
            }
            var data = {
                product_id: this.toSold.id,
                qty: this.qty,
                date: this.inputDate,
                user_id: this.user.id,
                soldTo: this.soldTo,
                isMaterial: this.isMaterial
            }
            this.$emit('sendSold', data)
            this.closeSold()
        },

    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'MATERIALS'
        ]),
        selectProduction() {
            if (this.isMaterial === '0') {
                return this.PRODUCTS
            }
            if (this.isMaterial === '1') {
                return this.MATERIALS
            }
        },
        isSelectedAndNoZero() {
            return !!(this.toSold && this.qty > 0);
        }
    },
    data() {
        return {
            qty: 0,
            soldTo: '',
            toSold: {},
            inputDate: new Date().toISOString().slice(0, 10),
            message: '',
            isMaterial: '0'
        }
    },
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
