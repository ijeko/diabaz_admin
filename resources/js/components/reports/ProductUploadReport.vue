<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">Отгрузки за месяц:
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
                                 v-for="(upload, index) in reportData.uploads"
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
                                                <div class="col-4">
                                                    {{ product.title }}
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col">{{ product.client }}</div>
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
                    <tr v-for="(product, index) in reportData.total"
                        :key="index"
                    >
                        <td class="title">
                            {{ index }}
                        </td>
                        <td>
                            {{ product.totalSold }} {{ product.unit }}
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
            localDate: this.commonDate,
            clientsUpload: [],
            lineToggle: 0
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
        uploadDay() {
            let dates = []
            for (let product of this.reportData) {
                for (let upload of product.upload) {
                    if (upload) {
                        console.log(upload.date)
                        dates.push(upload.date)
                    }
                }

            }
            return dates
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
        daysInMonth() {
            let date = new Date(Date.parse(this.localDate))
            return new Date(date.getFullYear(),
                date.getMonth() + 1,
                0).getDate();
        },
        getReport() {
            let data = {date: this.localDate, days: this.daysInMonth()}
            axios.get('/api/reports/upload', {
                headers: {'Content-Type': 'application/json'},
                params: data
            })
                .then(response => {
                    this.reportData = response.data
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
            'PRODUCTS'
        ]),
        colorToggle() {
            return this.lineToggle + 1
        }
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        localDate: function (newLocalDate, oldCLocalDate) {
            this.getReport()
        }
    },
    mounted() {
        this.getReport()
        this.isWeekend
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
</style>
