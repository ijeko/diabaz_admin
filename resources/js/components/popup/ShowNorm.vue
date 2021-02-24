<template>
    <div class="wrapper">
        <div class="text-right" @click="closeShowNorm">&times;</div>
        <h3 class="text-center mb-4">Нормы расхода</h3>
        <label>Название продукции</label>
        <select v-model="selectProd" class="form-control mb-4"
                @change="selectProduct($event)">
            <option value=""></option>
            <option v-for="product in PRODUCTS"
                    :key="product.id"
                    :value="product.id"
            >{{ product.title }}
            </option>
        </select>
        <div v-if="isSelected" class="normItem" v-for="item in SELECTED_NORM"
             :key="item.id"
        >
            <div class="normTitle">{{ item.title }}</div>
            <div class="normValue">{{ item.norma }} {{ item.unit }}</div>
        </div>

        <button class="btn btn-success mt-4" style="width: 100%" :disabled="!isSelected" @click="showAddForm">
            Изменить
        </button>
        <button class="btn btn-danger mt-4" style="width: 100%" @click="closeShowNorm">Закрыть</button>
        <add-mat-norm v-if="isAddFormVisible"
                      :selectedNorm="SELECTED_NORM"
                      :selectedProduct="selectProd"
        ></add-mat-norm>
    </div>

</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "ShowNorm",
    data() {
        return {
            isAddFormVisible: false,
            isSelected: false,
            localNorm: '',
            selectProd: '',
            norma: ''
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'SELECTED_NORM'
        ]),
    },
    methods: {
        ...mapActions([
            'GET_NORM_BY_MATERIAL'
        ]),
        closeShowNorm() {
            this.$emit('closeShowNorm')
        },
        selectProduct(event) {
            this.isSelected = true
            let id = event.target.value
            if (!id) {
                this.isSelected = false
                return false
            }
            let data = {prodID: id}
            this.GET_NORM_BY_MATERIAL(data)
        },
        showAddForm() {
            this.isAddFormVisible = true
        },
    },
    mounted() {

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
