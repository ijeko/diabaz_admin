<template>
    <div class="wrapper">
        <div class="text-right" @click="close">&times;</div>
        <h3 class="text-center mb-4">Редактировать</h3>
        <label>Название продукции</label>
        <input v-model="newProductName" class="form-control">
        <label>Краткое название на английском</label>
        <input v-model="newProductSlug" class="form-control">
        <label>Единица измерения</label>
        <input type="text" v-model="newProductUnit" class="form-control">
        <button class="btn btn-outline-success mt-4 actions" @click="saveProduct">
            Сохранить
        </button>
        <button class="btn btn-outline-danger mt-4 actions" @click="deleteProduct(PRODUCTS[selectedProduct].id)">
            Удалить
        </button>
        <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "newProduct",
    data() {
        return {}
    },
    props: {
        selectedProduct: '',
        newProductName: '',
        newProductSlug: '',
        newProductUnit: '',
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
        ]),

    },
    methods: {
        ...mapActions([]),
        close() {
            this.$emit('close')
        },
        productInfo() {
            // alert(this.PRODUCTS[this.selectedProduct].title)
            this.newProductName = this.PRODUCTS[this.selectedProduct].title
            this.newProductSlug = this.PRODUCTS[this.selectedProduct].name
            this.newProductUnit = this.PRODUCTS[this.selectedProduct].unit
        },
        saveProduct() {
            let data = JSON.stringify({
                id: this.PRODUCTS[this.selectedProduct].id,
                title: this.newProductName,
                name: this.newProductSlug,
                unit: this.newProductUnit
            })
            axios.post('http://127.0.0.1:8000/api/products/edit',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            this.$emit('update')
            this.$emit('close')
        },
        deleteProduct(id) {
            axios.delete('http://127.0.0.1:8000/api/products/remove',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: {id: id}
                })
                .then(function (response) {
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            this.$emit('update')
            this.$emit('close')
        }
    },
    mounted() {
        this.productInfo()
    }
}
</script>

<style scoped>
.wrapper {
    width: 500px;
    height: auto;
    position: absolute;
    top: 50px;
    left: 50%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.actions {
    width: 49%;
}
</style>
