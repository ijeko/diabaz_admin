<template>
    <div>
        <h3 class="text-center mb-4">{{ productWithMaterials.title }}</h3>
        <h5 class="text-center mb-4">Ввод расхода материалов</h5>
        <div v-if="message" class="alert alert-danger" role="alert">
            {{ message }}
        </div>
        <div v-if="message.auth" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.auth"
                  :key="index"
            >{{ error }}</span>
        </div>
        <div class="normItem" v-for="item in productWithMaterials.materialsNorms"
             :key="item.id"
        >
            <div class="input-group mb-3">
                <div class="input-group-prepend w-25">
                    <span class="input-group-text w-100">{{ item.title }}</span>
                </div>
                <input type="number"
                       class="form-control text-right"
                       aria-label="Amount (to the nearest dollar)"
                       v-model="item.norma">
                <div class="input-group-append">
                    <span class="input-group-text">{{ item.unit }}</span>
                </div>
                <div class="input-group-append">
                    <button class="btn btn-outline-danger"
                            type="button"
                            id="button-addon2"
                            @click="remove(item.id)"
                    >Удалить
                    </button>
                </div>
            </div>
        </div>
        <select v-if="isAddingNewMaterial"
                class="form-control mb-3"
                name="material" id="material"
                @change="addItem"
                v-model="selectedMat">
            <option value=""></option>
            <option v-for="(material, index) in materialsNotAdded"
                    :key="material.id"
                    :value="material"
            >{{ material.title }}
            </option>
        </select>
        <button class="btn-lg btn-secondary float-right"
                :disabled="isAddingNewMaterial"
                @click="showSelect"
        >+
        </button>
        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="sendData">Сохранить</button>
        <button class="btn btn-outline-danger mt-2" style="width: 100%" @click="close">Закрыть</button>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "AddMatNorm",
    data() {
        return {
            title: '',
            selectedMat: {},
            norma: 0,
            message: '',
            isAddingNewMaterial: false
        }
    },
    props: {
        productWithMaterials: '',
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
        ]),
        materialsNotAdded () {
            var allMaterials = this.MATERIALS;

            var addedMaterials = this.productWithMaterials.materialsNorms;

            var filteredArray  = allMaterials.filter(function(allMaterials_el){
                return addedMaterials.filter(function(addedMaterials_el){
                    return addedMaterials_el.material_id === allMaterials_el.id;
                }).length === 0
            });
            return filteredArray
        }
    },
    methods: {
        ...mapActions([
            'EDIT_SELECTED_NORM'
        ]),
        showSelect() {
            this.isAddingNewMaterial = true
        },
        close() {
            this.$emit('update', {prodID: this.productWithMaterials.id})
            this.$emit('close')
        },
        addItem() {
            this.isAddingNewMaterial = false
            this.productWithMaterials.materialsNorms.push({
                title: this.selectedMat.title,
                norma: 0,
                unit: this.selectedMat.unit,
                material_id: this.selectedMat.id,
                product_id: this.productWithMaterials.id
            })
        },
        sendData() {
            for (let item of this.productWithMaterials.materialsNorms) {
                if (item.norma <= 0) {
                    this.message = 'Расход должен быть больше 0'
                    return false
                }
            }
            this.EDIT_SELECTED_NORM(JSON.stringify(this.productWithMaterials.materialsNorms))
            this.$emit('update', {prodID: this.productWithMaterials.id})
        },
        remove(id) {
            alert(id)
            axios.delete('/api/matnorm/remove',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: {id: id}
                })
                .then(response => {
                    this.$emit('update', {prodID: this.productWithMaterials.id})
                    return response.data
                })
                .catch(error => {
                    if (error.response) {
                        this.message = error.response.data.errors
                    }
                    return error
                })
        }
    }
}
</script>

<style scoped>
input {
    width: 60px;
}

.wrapper {
    position: center;
    z-index: 1;
    background-color: white;
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
