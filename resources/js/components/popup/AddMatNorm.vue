<template>
    <div class="wrapper">
        <div class="text-right" @click="closeAddForm">&times;</div>
        <h3 class="text-center mb-4">Расход материалов:</h3>
        <div class="normItem" v-for="item in selectedNorm"
             :key="item.id"
        >
            <div class="normTitle">{{ item.title }}</div>
            <div class="normValue"><input type="number" :value="item.norma"> {{ item.unit }}</div>
        </div>
        <select class="form-control" name="material" id="material">
            <option value=""></option>
            <option v-for="material in MATERIALS"
                    :key="material.id"
                    :value="material.id"
            >{{ material.title }}
            </option>
        </select>
        <button class="btn btn-success mt-4" style="width: 100%">Изменить</button>
        <button class="btn btn-danger mt-4" style="width: 100%" @click="closeAddForm">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "AddMatNorm",
    data() {
        return {
            title: '',
            selectMat: '',
            selectProd: '',
            norma: ''
        }
    },
    props: {
        selectedNorm: '',
        selectedProduct: ''
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
            'PRODUCTS'
        ])
    },
    methods: {
        ...mapActions([]),
        closeAddForm() {
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
.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
