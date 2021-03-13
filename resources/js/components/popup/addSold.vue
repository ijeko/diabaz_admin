<template>
    <div class="body">
        <div @click="closeSold">&times;</div>
        <div class="container">
            <div class="mt-1">
                <div class="text-center"><h3>Отгружено:</h3></div>
                <form class="" action="">
                    <label for="date">Дата:</label>
                    <input v-model="inputDate" type="date" class="form-control" id="date">
                    <label for="product">Продукция</label>
                    <select  v-model="selectedProduct" name="product" id="product" class="form-control">
<!--                        <option value="asd" disabled>Продукция</option>-->
                        <option
                            :value="index"
                            v-for="(product, index) in products"
                           >{{product.title}}</option>
                    </select>
                    <label for="qty">Количество, {{products[selectedProduct].unit}}</label>
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

export default {
    name: "popup",
    props: {
        products: {
            type: Array,
            default: [],
        },
        user: ''

    },
    methods: {
        closeSold () {
            this.$emit('closeSold')
        },
        sendSold () {
            var data = {product_id: this.products[this.selectedProduct].id, qty: this.qty, date: this.inputDate, user_id: this.user, soldTo: this.soldTo}
            this.$emit('sendSold', data)
            this.closeSold()
        }
    },
    data () {
        return {
            qty: 0,
            soldTo: '',
            selectedProduct: 0,
            inputDate: new Date().toISOString().slice(0,10)
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
