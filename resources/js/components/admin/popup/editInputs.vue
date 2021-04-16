<template>
    <div>
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse"
                                data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne"
                                @click="clearData"
                        >
                            Редактировать производство
                        </button>
                    </h2>
                </div>

                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                Производство за {{dateFormated.ofMonth}} {{ dateFormated.year}}
                            </div>
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios1"
                                           value="produced"
                                           v-model="producedOrSpoiled"
                                           checked>
                                    <label class="form-check-label" for="exampleRadios1">
                                        Произведено
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="exampleRadios"
                                           id="exampleRadios2"
                                           value="spoiled"
                                           v-model="producedOrSpoiled">
                                    <label class="form-check-label" for="exampleRadios2">
                                        Списано
                                    </label>
                                </div>
                                <div v-if="message.auth" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.auth"
                  :key="index"
            >{{ error }}</span>
                                </div>
                                <select class="form-control"
                                        v-model="selectedProduct"
                                        name="products"
                                        id="products"
                                        @change="getProductWithPayload()"
                                >
                                    <option
                                        v-for="(product, index) in PRODUCTS"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        {{ product.title }}
                                    </option>
                                </select>
                                <div class="list">
                                    <div class="container">
                                        <table class="w-100">
                                            <tr>
                                                <th class="text-center">Дата</th>
                                                <th class="text-center">Количество</th>
                                                <th class="text-center">Действие</th>

                                            </tr>
                                            <tr v-if="selectedProduct"
                                                v-for="item in productPayload"
                                                :key="item.id">
                                                <td class="text-center"><span>{{ item.date }}</span></td>
                                                <td class="text-center"><span>
                                                    {{ item.qty }}
                                                    {{product.unit }}
                                                </span>
                                                </td>
                                                <td class="text-center"><span class="btn btn-link m-0"
                                                                              v-if="producedOrSpoiled === 'produced'"
                                                                              @click="remove('Produced', item.id)">Удалить</span>
                                                </td>
                                                <td class="text-center"><span class="btn btn-link m-0"
                                                                              v-if="producedOrSpoiled === 'spoiled'"
                                                                              @click="remove('Spoiled', item.id)">Удалить</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"
                                @click="clearData"
                        >
                            Редактировать отгрузки
                        </button>
                    </h2>
                </div>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                Отгрузки за {{dateFormated.ofMonth}} {{ dateFormated.year}}
                                <div v-if="message.auth" class="alert alert-danger" role="alert">
            <span v-for="(error, index) of message.auth"
                  :key="index"
            >{{ error }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <select class="form-control"
                                        v-model="selectedProduct"
                                        name="uploads"
                                        id="uploads"
                                        @change="getProductWithPayload()"
                                >
                                    <option
                                        v-for="(product, index) in PRODUCTS"
                                        :key="product.id"
                                        :value="product.id"
                                    >
                                        {{ product.title }}
                                    </option>
                                </select>
                                <div class="list">
                                    <div class="container">
                                        <table class="w-100">
                                            <tr>
                                                <th class="text-center">Дата</th>
                                                <th class="text-center">Клиент</th>
                                                <th class="text-center">Количество</th>
                                                <th class="text-center">Действие</th>

                                            </tr>
                                            <tr v-if="selectedProduct"
                                                v-for="upload in product.dailySold"
                                                :key="upload.id">
                                                <td class="text-center"><span>{{ upload.date }}</span></td>
                                                <td class="text-center">{{ upload.soldTo }}</td>
                                                <td class="text-center"><span>{{ upload.qty }}
                                                    {{ product.unit }}
                                                </span>
                                                </td>
                                                <td class="text-center"><span class="btn btn-link m-0"
                                                                              @click="remove('Sold', upload.id)">Удалить</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#editMaterials" aria-expanded="false" aria-controls="editMaterials">
                            Редактировать поступления материалов
                        </button>
                    </h2>
                </div>
                <div id="editMaterials" class="collapse" aria-labelledby="editMaterials" data-parent="#editMaterials">
                    <div class="card-body">
                        And lastly, the placeholder content for the third and final accordion panel. This panel is
                        hidden by default.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="editIncomesbtn">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#editIncomes" aria-expanded="false" aria-controls="editIncomes">
                            Редактировать нормы расхода материалов
                        </button>
                    </h2>
                </div>
                <div id="editIncomes" class="collapse" aria-labelledby="editIncomes" data-parent="#editMaterials">
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                Для редактирования выберите продукт
                            </div>
                            <div class="card-body" v-if="!isAddFormVisible">
                                <label>Продукт:</label>
                                <select v-model="selectProd" class="form-control mb-4"
                                        @change="selectProductForNorm($event)">
                                    <option value=""></option>
                                    <option v-for="product in PRODUCTS"
                                            :key="product.id"
                                            :value="product.id"
                                    >{{ product.title }}
                                    </option>
                                </select>
                                <div v-if="isSelected" class="normItem"
                                     v-for="item in PRODUCT_MATERIAL_NORMS.materialsNorms"
                                     :key="item.id"
                                >
                                    <div class="normTitle">{{ item.title }}</div>
                                    <div class="normValue">{{ item.norma }} {{ item.unit }}</div>
                                </div>

                                <button class="btn btn-outline-success mt-4" style="width: 100%" :disabled="!isSelected"
                                        @click="showAddForm">
                                    Изменить
                                </button>

                            </div>
                            <div class="card-body">
                                <add-mat-norm v-if="isAddFormVisible"
                                              :productWithMaterials="PRODUCT_MATERIAL_NORMS"
                                              :selectedProduct="selectProd"
                                              @close="showAddForm"
                                              @update="GET_PRODUCT_WITH_MATERIALS"
                                ></add-mat-norm>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "editInputs",
    props: {
        dateFormated: '',
        user: '',
        // date:''
        commonDate: '',
    },
    data() {
        return {
            date: new Date(),
            product: '',
            localDate: this.commonDate,
            clientsUpload: [],
            lineToggle: 0,
            selectedProduct: '',
            process: '',
            isSelected: '',
            selectProd: '',
            isAddFormVisible: false,
            producedOrSpoiled: 'produced',
            message: ''

        }
    },
    watch: {
        dateFormated: function (newdateFormated, olddateFormated) {
            this.selectedProduct = ''
        },
        producedOrSpoiled: function (newProducedOrSpoiled, oldProducedOrSpoiled) {
            this.selectedProduct = ''
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'GET_PRODUCT_WITH_MATERIALS'
        ]),
        showAddForm() {
            if (this.isAddFormVisible === true) {
                this.isAddFormVisible = false
            } else {
                this.isAddFormVisible = true
            }

        },
        clearData() {
            this.selectedProduct = ''
        },
        getProductWithPayload() {
            let data = {product: this.selectedProduct}
            let $url = '/api/admin/product'
            axios.get($url, {
                headers: {'Content-Type': 'application/json'},
                params: data
            })
                .then(response => {
                    this.product = response.data
                  console.log(this.product)
                    return response.data
                })
                .catch(error => {
                    if (error.response) {
                        this.message = error.response.data.errors
                    }
                    return error
                })
        },
        remove(model, id) {
            let data = {model: model, id: id}
            if (confirm('Точно удалить?')) {
                axios.delete('/api/products/operations',
                    {
                        headers: {'Content-Type': 'application/json'},
                        params: data
                    })
                    .then(response => {
                        this.clearData()
                        return response.data
                    })
                    .catch(error => {
                        if (error.response) {
                            this.message = error.response.data.errors
                        }
                        return error
                    })

            }
        },
        selectProductForNorm(event) {
            this.isSelected = true
            let id = event.target.value
            if (!id) {
                this.isSelected = false
                return false
            }
            let data = {prodID: id}
            this.GET_PRODUCT_WITH_MATERIALS(data)
        },
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'PRODUCT_MATERIAL_NORMS'
        ]),
        productPayload ()
        {
            if (this.producedOrSpoiled === 'produced')
            {
                return this.product.dailyProduction
            }
            else return this.product.dailySpoiled
        }
    },
    mounted() {
        this.GET_PRODUCTS()
    }
}
</script>

<style scoped>
.wrapper {
    width: auto;
    height: auto;
    position: sticky;
    /*top: 30%;*/
    /*right: 25%;*/
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.listItem > div {
    margin-right: 10px;
    /*width: 100px;*/
}

.monthBtn {
    width: 100px;
}

.normItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
