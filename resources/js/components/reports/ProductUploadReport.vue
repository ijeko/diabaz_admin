<template>
    <div>
        <component-loader v-if="isLoading"></component-loader>
        <div class="card mt-4">
            <div class="card-header">Отгрузки за {{ FORMATED_DATE.ofMonth }} {{FORMATED_DATE.year}}
            </div>
            <div class="card-body">
                <div class="container result-table">
                    <div class="row text-light bg-dark">
                        <div class="col-3">Дата</div>
                        <div class="col-3">Продукция</div>
                        <div class="col-3">Контрагент</div>
                        <div class="col-3">Количество</div>
                    </div>
                    <div class="row"
                    >
                        <div class="col date">
                            <div class="row date-line"
                                 v-for="(upload, index) in reportData.dailySolds"
                                 :key="index"
                            >
                                <div class="col-3 date-block">
                                    {{ index }}
                                </div>
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row item"
                                                 v-for="product in upload"
                                                 :key="product.id"
                                            >
                                                <div class="col-4 lightable"
                                                     @click="lightUp (product.title)"
                                                     :class="{'bg-info' : light===product.title}"
                                                >
                                                    {{ product.title }}
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col lightable"
                                                             @click="lightUp (product.client)"
                                                             :class="{'bg-info' : light===product.client}"
                                                        >{{ product.client }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col">
                                                            {{ product.qty }} {{ product.unit }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">Всего отгружено за месяц:</div>
            <div class="card-body">
                <table class="table table-striped col-6">
                    <thead>
                    <tr>
                        <th class="title">Продукция</th>
                        <th class="cells">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) in reportData.products"
                        :key="index"
                        v-if="product.monthlySold"
                    >
                        <td class="title">
                            {{ product.title }}
                        </td>
                        <td>
                            {{ product.monthlySold }} {{ product.unit }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "ProductUploadReport",
    data() {
        return {
            date: new Date(),
            reportData: [],
            localDate: '',
            clientsUpload: [],
            lineToggle: 0,
            light: '',
            isLoading:''
        }
    },
    props: {
        commonDate: '',
        dateFormated: '',
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),

        lightUp (item) {
            this.light = item

        },
        lightUpCl (item) {
            this.lightUpClient = ''
            this.lightUpProduction = ''
            this.lightUpClient = item

        },
        getReport() {
            this.isLoading = true
            axios.get('/api/reports/upload', {
                headers: {'Content-Type': 'application/json'},
            })
                .then(response => {
                    this.reportData = response.data
                    this.isLoading = false
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'DATE',
            'FORMATED_DATE'
        ]),
        colorToggle() {
            return this.lineToggle + 1
        }
    },
    mounted() {
        this.getReport()
    }
}
</script>

<style scoped>
.date-line {
    /*border-bottom: 1px solid silver;*/
    margin-bottom: 10px;
}

.item {
    border-bottom: 1px solid silver;
    padding: 5px;
}

.monthBtn {
    width: 100px;
}

.date-block {
    border-bottom: 1px solid silver;
}
.lightable {
    cursor: pointer;
}
</style>
