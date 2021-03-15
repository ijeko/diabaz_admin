<template>
    <div class="wrapper">
        <div class="text-right" @click="closeEditForm">&times;</div>
        <h3 class="text-center mb-4">{{productById(selectedProduct).title}}</h3>
        <h5 class="text-center mb-4">Ввод расхода материалов</h5>
        <div v-if="message" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
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
            <div class="del" @click="remove(item.id)">&times;</div>
        </div>
        <select class="form-control" name="material" id="material" @change="addItem" v-model="selectedMat">
            <option value=""></option>
            <option v-for="(material, index) in MATERIALS"
                    :key="material.id"
                    :value="index"
            >{{ material.title }}
            </option>
        </select>
        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="test">Сохранить</button>
        <button class="btn btn-outline-danger mt-2" style="width: 100%" @click="closeEditForm">Закрыть</button>
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
            selectedMat: [],
            norma: '',
            message: ''
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
        productById(id)
        {

            var title = this.PRODUCTS.find(material => material.id === id)
            var unit = this.PRODUCTS.find(material => material.id === id)
            if (title && unit)
            {
                let data = {title: title.title, unit: unit.unit}
                return data
            }
            else return false
        },
        closeEditForm() {
            this.$emit('closeEditForm')
        },
        addItem () {
            let material= this.MATERIALS[this.selectedMat]
            this.selectedNorm.push({id:null,title: material.title, norma: 0, unit: material.unit, material_id: material.id, product_id: this.selectedProduct})
            console.log(this.selectedNorm)
        },
        test() {
            if (this.norma <=0) {
                this.message = 'Расход должен быть больше 0'
                return false
            }
            // console.log(this.selectedNorm)
            this.EDIT_SELECTED_NORM(JSON.stringify(this.selectedNorm))
            this.$emit('update', {prodID: this.selectedProduct})
            this.closeEditForm()
        },
        remove (id) {
            axios.delete('http://127.0.0.1:8000/api/matnorm/remove',
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
            this.$emit('update', {prodID: this.selectedProduct})
        }
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
.del {
    background-color: rosybrown;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    color: white;
    text-align: center;
    /*font-size: 18px;*/
    vertical-align: middle;
}
.del:hover {
    background-color: red;
    cursor: pointer;
}
.normTitle, .normValue {
    width: 45%;
}
</style>
