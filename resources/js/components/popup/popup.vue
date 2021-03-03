<template>
    <div class="body">
        <div @click="closePopup">&times;</div>
        <div class="container">
            <div class="mt-1">
                <div class="text-center"><h3>Произведено:</h3></div>
                <form class="" action="">
                    <label for="date">Дата:</label>
                    <input v-model="inputDate" type="date" class="form-control" id="date">
                    <label for="product">Материал</label>
                    <select  v-model="selectedProduct" name="product" id="product" class="form-control">
<!--                        <option value="asd" disabled>Продукция</option>-->
                        <option
                            :value="product.id"
                            v-for="(product, index) in products"
                           >{{product.title}}</option>
                    </select>
                    <label for="qty">Количество, {{products[selectedProduct-1].unit}}</label>
                    <input v-model="qty" class="form-control" type="number" id="qty">
                </form>
            </div>

            <div class="mt-3">
                <button class="btn btn-outline-dark mt-30" @click="sendProduced">Сохранить</button>
            </div>
            <div class="mt-3">
                <button class="btn btn-outline-danger mt-30" @click="closePopup">Закрыть</button>
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
        closePopup () {
            this.$emit('closePopup')
        },
        sendProduced () {

            var data = {product_id: this.selectedProduct, qty: this.qty, date: this.inputDate, user_id: this.user}
            this.$emit('sendProduced', data)
        }
    },
    data () {
        return {
            qty: 0,
            selectedProduct: 1,
            inputDate: new Date().toISOString().slice(0,10)
        }
    }
}
</script>

<style scoped>
.body {
    background-color: #cbd5e0;
    width: 400px;
    height: 400px;
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
