<template>
    <div class="body">
        <div @click="closeSold">&times;</div>
        <div class="container">
            <div class="mt-1">
                <div class="text-center"><h3>Отгружено:</h3></div>
                <div v-if="message" class="alert alert-danger" role="alert">
                    {{ message }}
                </div>
                <form class="" action="">
                    <label for="date">Дата:</label>
                    <input v-model="inputDate" type="date" class="form-control" id="date">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                               value="product"
                               v-model="productionType"
                               checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Продукция
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                               value="material"
                               v-model="productionType">
                        <label class="form-check-label" for="exampleRadios2">
                            Материалы
                        </label>
                    </div>
                    <select  v-model="selectedProduct" name="product" id="product" class="form-control">
<!--                        <option value="asd" disabled>Продукция</option>-->
                        <option
                            :value="index"
                            v-for="(product, index) in selectProduction"
                           >{{product.title}}</option>
                    </select>
                    <label for="qty">Количество, {{selectProduction[selectedProduct].unit}}</label>
                    <input v-model="qty" class="form-control" type="number" id="qty">
                    <label for="soldTo">Кому:</label>
                    <input v-model="soldTo" class="form-control" type="text" id="soldTo">
                </form>
            </div>

            <div class="mt-3">
                <button class="btn btn-outline-dark mt-30" @click="sendSold">Сохранить</button>
            </div>
            <div class="mt-3">
                <button class="btn btn-outline-danger mt-30" @click="closeSold">Закрыть</button>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    name: "popup",
    props: {
        // products: {
        //     type: Array,
        //     default: [],
        // },
        user: {}

    },
    methods: {
        closeSold () {
            this.$emit('closeSold')
        },
        sendSold () {
            if (this.qty <= 0) {
                this.message = 'Количество должно быть больше 0'
                return false
            }
            var data = {product_id: this.selectProduction[this.selectedProduct].id,
                qty: this.qty,
                date: this.inputDate,
                user_id: this.user.id,
                soldTo: this.soldTo,
                model: this.productionType}
            this.$emit('sendSold', data)
            this.closeSold()
        },

    },
    computed: {
      ...mapGetters([
          'PRODUCTS',
          'MATERIALS'
      ]),
        selectProduction ()
        {
            if (this.productionType === 'product') {
                return this.PRODUCTS
            }
            if (this.productionType === 'material') {
                return this.MATERIALS
            }
        }
    },
    data () {
        return {
            production: this.selectProduction,
            qty: 0,
            soldTo: '',
            selectedProduct: 0,
            inputDate: new Date().toISOString().slice(0,10),
            message: '',
            productionType: 'product'
        }
    },
    beforeMount() {
        this.production = this.PRODUCTS
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
