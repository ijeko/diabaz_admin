<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">Отгрузки за месяц: <div class="btn-group mr-2" role="group" aria-label="Second group">
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
            </div></div>
            <div class="card-body">
                <div class="container result-table">
                    <div class="row">
                        <div class="col-3">Дата</div>
                        <div class="col-3">Продукция</div>
                        <div class="col-3">Контрагент</div>
                        <div class="col-3">Количество</div>
                    </div>
                    <div class="row">
                        <div class="col bg-light date">
                            <div class="row"v-for="(day, index) in uploadDay()"
                                 :key="index">
                                <div class="col-3 bg-info">
                                    {{ day }}
                                </div>
                                <div class="col-9 bg-warning">
                                    <div class="row">
                                        <div class="col bg-danger">
                                            <div class="row"
                                            v-for="(product, index) in reportData"
                                                 :key="index"
                                                 v-if="product.monthly"
                                            >
                                                <div class="col-4">
                                                    {{ product.title }}
                                                </div>
                                                <div class="col-4">
                                                    <div class="row" v-for="(client, index) in clientsUpload"
                                                    :key="index">
                                                        <div class="col">{{client.client}}</div>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="row">
                                                        <div class="col">
                                                            {{clientsUpload}}
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
            clientsUpload: []
        }
    },
    props: {
        commonDate: '',
        dateFormated: ''
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        uploadDay () {
            let dates = []
            for (let product of this.reportData)
            {
                for (let upload of product.upload)
                {
                    if (upload) {
                        console.log(upload.date)
                        dates.push(upload.date)
                    }
                }

            }
            return dates
        },
        clients () {

            let clients = []
            for (let product of this.reportData)
            {
                for (let upload of product.upload)
                {
                    if (upload) {
                        clients.push({qty: upload.qty, client : upload.soldTo})
                        console.log(clients)
                    }
                }
                console.log(clients)
            }
            return this.clientsUpload = clients
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
            axios.get('http://127.0.0.1:8000/api/reports/upload', {
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
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS'
        ]),
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
        this.clients()
    }
}
</script>

<style scoped>

</style>
