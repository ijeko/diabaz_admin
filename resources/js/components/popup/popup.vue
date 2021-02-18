<template>
    <div class="body">
        <div @click="closePopup">&times;</div>
        <div class="container">
            <div class="mt-5">
                <form class="" action="">

                    <select name="product" id="product" class="form-control m-2">
                        <option value="asd" disabled>Продукция</option>
                        <option
                            v-for="(product, index) in products"
                            v-model="selectedProduct">{{product.title}}</option>
                    </select>
                    <input v-model="qty" class="form-control m-2" type="number">
                </form>
            </div>

            <div class="">
                <button class="btn btn-dark mt-30" @click="closePopup">Сохранить</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "popup",
    props: {
        products: []
    },
    methods: {
        closePopup () {
            this.$emit('closePopup')
        },
        save () {
            var data = {product: this.selectedProduct, produced: this.qty}
            return data
        }
    },
    data () {
        return {
            qty: 0,
            selectedProduct: ''
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
