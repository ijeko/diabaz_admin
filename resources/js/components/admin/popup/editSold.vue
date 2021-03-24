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
                                Производство за месяц
                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn-secondary"
                                            @click="decreaseMonth"
                                    > <
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary monthBtn"
                                            @click="resetMonth"
                                    >{{ dateFormated.ofMonth }}
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                            @click="increaseMonth"
                                    > >
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <select class="form-control"
                                        v-model="selectedProduct"
                                        name="products"
                                        id="products"
                                        @change="getReport('Produced')"
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
                                                v-for="produced in responseData"
                                                :key="produced.id">
                                                <td class="text-center"><span>{{ produced.date }}</span></td>
                                                <td class="text-center"><span>{{ produced.qty }}
                                                    {{ PRODUCTS.find(x => x.id === produced.product_id).unit }}</span>
                                                </td>
                                                <td class="text-center"><span class="btn btn-link m-0"
                                                                              @click="remove('Produced', produced.id)">Удалить</span>
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
                                Отгрузки за месяц
                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button type="button" class="btn btn-secondary"
                                            @click="decreaseMonth"
                                    > <
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary monthBtn"
                                            @click="resetMonth"
                                    >{{ dateFormated.ofMonth }}
                                    </button>
                                    <button type="button" class="btn btn-secondary"
                                            @click="increaseMonth"
                                    > >
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <select class="form-control"
                                        v-model="selectedProduct"
                                        name="uploads"
                                        id="uploads"
                                        @change="getReport('Sold')"
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
                                                <!--                    <th>Остатки??</th>-->
                                                <th class="text-center">Клиент</th>
                                                <th class="text-center">Количество</th>
                                                <th class="text-center">Действие</th>

                                            </tr>
                                            <tr v-if="selectedProduct"
                                                v-for="upload in responseData"
                                                :key="upload.id">
                                                <td class="text-center"><span>{{ upload.date }}</span></td>
                                                <td class="text-center">{{ upload.soldTo }}</td>
                                                <td class="text-center"><span>{{ upload.qty }}
                                                    {{ PRODUCTS.find(x => x.id === upload.product_id).unit }}</span>
                                                </td>
                                                <td class="text-center"><span class="btn btn-link m-0"
                                                                              @click="remove('Sold', upload.id)">Удалить</span>
                                                </td>
                                            </tr>
                                        </table>
                                        <!--                                        <div class="row" v-if="selectedProduct"-->
                                        <!--                                             v-for="upload in uploads"-->
                                        <!--                                             :key="upload.id">-->
                                        <!--                                            <div class="container d-inline-flex listItem justify-content-between">-->
                                        <!--                                                <div class="date">{{ upload.date }}</div>-->
                                        <!--                                                &lt;!&ndash;                                <div class="product text-nowrap">{{PRODUCTS.find(x => x.id === upload.product_id).title}}</div>&ndash;&gt;-->
                                        <!--                                                <div class="client">{{ upload.soldTo }}</div>-->
                                        <!--                                                <div class="qty">{{ upload.qty }}-->
                                        <!--                                                    {{ PRODUCTS.find(x => x.id === upload.product_id).unit }}-->
                                        <!--                                                </div>-->
                                        <!--                                                <div class="action">удалить</div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
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
                                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Редактировать материалы
                        </button>
                    </h2>
                </div>
                <div id="materialIncomes" class="collapse" aria-labelledby="incomes" data-parent="#accordionExample">
                    <div class="card-body">
                        And lastly, the placeholder content for the third and final accordion panel. This panel is
                        hidden by default.
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header" id="incomes">
                    <h2 class="mb-0">
                        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse"
                                data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Редактировать нормы расхода материалов
                        </button>
                    </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        And lastly, the placeholder content for the third and final accordion panel. This panel is
                        hidden by default.
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "editSold",
    props: {
        dateFormated: '',
        user: '',
        // date:''
        commonDate: '',
    },
    data() {
        return {
            date: new Date(),
            responseData: [],
            localDate: this.commonDate,
            clientsUpload: [],
            lineToggle: 0,
            selectedProduct: '',
            process: ''
        }
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        localDate: function (newLocalDate, oldCLocalDate) {
            this.getReport(this.process)
        },
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        clearData() {
            this.selectedProduct = ''
        },
        decreaseMonth() {
            let currentDate = new Date(Date.parse(this.localDate))
            currentDate.setDate(1);
            currentDate.setMonth(currentDate.getMonth() - 1);
            this.localDate = currentDate.toISOString().slice(0, 10)
            this.$emit('setDate', currentDate.toISOString().slice(0, 10))
            // console.log(currentDate.toISOString().slice(0, 10))
        },
        increaseMonth() {
            let currentDate = new Date(Date.parse(this.localDate))
            currentDate.setDate(1);
            currentDate.setMonth(currentDate.getMonth() + 1);
            this.localDate = currentDate.toISOString().slice(0, 10)
            this.$emit('setDate', currentDate.toISOString().slice(0, 10))
            // console.log(currentDate.toISOString().slice(0, 10))
        },
        resetMonth() {
            this.localDate = new Date().toISOString().slice(0, 10)
            this.$emit('setDate', this.localDate)
        },
        getReport(process) {
            this.process=process
            let data = {date: this.localDate, product: this.selectedProduct, process: this.process}
            axios.get('/api/products/operations', {
                headers: {'Content-Type': 'application/json'},
                params: data
            })
                .then(response => {
                    this.responseData = response.data
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
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
                    .then(function (response) {
                        return data
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                this.clearData()
            }
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS'
        ])
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
</style>
