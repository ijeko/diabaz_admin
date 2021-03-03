<template>
    <div class="wrapper">
        <div class="text-right" @click="close">&times;</div>
        <h3 class="text-center mb-4">Новая продукция</h3>
        <label>Название продукции</label>
        <input v-model="title" class="form-control" list="production">
        <div v-if="error">{{error}}</div>
        <datalist id="production">
            <option v-for="product in PRODUCTS">{{ product.title }}</option>
        </datalist>
        <label>Краткое название на английском</label>
        <input v-model="name" class="form-control">
        <label>Единица измерения</label>
        <input type="text" v-model="unit" class="form-control">
        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="addProduct">
            Сохранить
        </button>
        <button class="btn btn-outline-dark mt-2" style="width: 100%" @click="close">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "newProduct",
    data() {
        return {
            title: '',
            name: '',
            unit: '',
            error: ''

        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS'
        ]),
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        close() {
            this.$emit('close')
        },
        addProduct() {
            let data = JSON.stringify({
                title: this.title,
                name: this.name,
                unit: this.unit
            })
            axios.post('http://127.0.0.1:8000/api/products/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(function (response) {
                    return response.data
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
        this.GET_PRODUCTS()
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

.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
