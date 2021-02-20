<template>
    <div class="body">
        <div @click="closePopup">&times;</div>
        <div class="container">
            <div class="mt-5">
                <form class="" action="">
                    <input v-model="inputDate" type="date" class="form-control">

                    <select  v-model="selectedProduct" name="product" id="product" class="form-control">
                        <option value="asd" disabled>Продукция</option>
                        <option
                            :value="product.id"
                            v-for="(product, index) in products"
                           >{{product.title}}</option>
                    </select>
                    <input v-model="qty" class="form-control" type="number">
                </form>
            </div>

            <div class="">
                <button class="btn btn-dark mt-30" @click="sendProduced">Сохранить</button>
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
            selectedProduct: [],
            inputDate: new Date().toISOString().slice(0,10)
        }
    }
}
</script>

<style scoped>
.body {
    background-color: #cbd5e0;
    width: 400px;
    height: 200px;
    position: absolute;
    left: 60px;
    top: 30%;
    z-index: 1;
}
</style>
