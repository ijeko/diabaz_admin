<template>
    <div class="wrapper">
        {{selectedNorm}}
        <button @click="remove(12)"></button>
        <div class="text-right" @click="closeAddForm">&times;</div>
        <h3 class="text-center mb-4">{{PRODUCTS[selectedProduct-1].title}}</h3>
        <h5 class="text-center mb-4">Ввод расхода материалов</h5>
        <div class="normItem" v-for="item in selectedNorm"
             :key="item.id"
        >
            <div class="normTitle">
                {{ item.title }}
            </div>
            <div class="normValue">
                <input type="number" v-model="item.norma">
                {{ item.unit }}
            </div>
        </div>
        <select class="form-control" name="material" id="material" @change="addItem" v-model="selectedMat">
            <option value=""></option>
            <option v-for="(material, index) in MATERIALS"
                    :key="material.id"
                    :value="material.id"
            >{{ material.title }}
            </option>
        </select>
        <button class="btn btn-success mt-4" style="width: 100%" @click="test">Сохранить</button>
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
            selectedMat: '',
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
        ...mapActions([
            'EDIT_SELECTED_NORM'
        ]),
        closeAddForm() {
            this.$emit('closeAddForm')
        },
        addItem () {

            let material= this.MATERIALS[this.selectedMat-1]
            this.selectedNorm.push({id:null,title: material.title, norma: 0, unit: material.unit, material_id: material.id, product_id: this.selectedProduct})
        },
        test() {
            console.log(this.selectedNorm)
            this.EDIT_SELECTED_NORM(JSON.stringify(this.selectedNorm))
        },
        remove (id) {
            axios.post('http://127.0.0.1:8000/api/matnorm/remove',
                {id},
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
