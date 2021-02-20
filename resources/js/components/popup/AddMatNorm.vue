<template>
<div class="wrapper">
    <div class="text-right" @click="closeAddForm">&times;</div>
    <h3 class="text-center mb-4">Добавить норму расхода</h3>
    <label for="title">Название</label>
    <input class="form-control" disabled type="text" id="title" :value="selectProd">
    <label for="product">Выбирите продукцию</label>
    <select v-model="selectProd" class="form-control" name="product" id="product">
        <option value=""></option>
        <option v-for="product in PRODUCTS"
                :key="product.id"
        >{{product.title}}</option>
    </select>
    <label for="material">Выбирите материал</label>
    <select class="form-control" name="material" id="material">
        <option value=""></option>
        <option v-for="material in MATERIALS"
        :key="material.id"
        >{{material.title}}</option>
    </select>
    <label for="title">Норма расхода</label>
    <input class="form-control" type="number" id="title">
    <button class="btn btn-success mt-4" style="width: 100%">Добавить</button>
</div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
export default {
    name: "AddMatNorm",
    data () {
        return {
            title: '',
            selectMat: '',
            selectProd: '',
            norma: ''
        }
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
            'PRODUCTS'
        ])
    },
    methods: {
        ...mapActions([
        ]),
        closeAddForm () {
            this.$emit('closeAddForm')
        }
    }
}
</script>

<style scoped>
.wrapper {
    width: 500px;
    height: 600px;
    position: absolute;
    top: 50px;
    left: 50%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}
</style>
