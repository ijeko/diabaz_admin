<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">
                Произведено продукции за {{ dateFormated.ofMonth }} {{ dateFormated.year }}
            </div>
            <div class="card-body">
                <component-loader v-if="isLoading"></component-loader>
                <div class="container flex-fill">
                    <div class="row">
                        <div class="col-6 production-title bg-light col-md-3 col-sm-5 ">
                            <div class="row bg-light table-header">
                                <div class="col text-center">Продукция</div>
                            </div>
                            <div class="row flex-nowrap"
                                 v-for="product in reportData"
                                 :key="product.id"
                                 v-if="product.monthlyProduction"
                            >
                                <div class="col">{{ product.title }}, {{ product.unit }}</div>
                            </div>
                        </div>
                        <div class="col-6 col-md-9 col-sm-7 horizontal-scrollable ">
                            <div class="row flex-nowrap table-header">
                                <div class="col m-0 p-0"
                                     v-for="(days, index) in daysInMonth()"
                                     :key="index">
                                    <div class="data-cell m-0 p-0 text-center bg-light"
                                         :class="{'text-danger': isWeekend(days.day) }"
                                    >{{ days.day }}<br>{{ days.dayName }}
                                    </div>
                                </div>
                            </div>
                            <div class="row flex-nowrap"
                                 v-if="product.monthlyProduction"
                                 v-for="product in reportData"
                                 :key="product.id"
                            >
                                <div class="col m-0 p-0"
                                     v-for="(date, index) in datesArray()"
                                     :key="index">
                                    <div
                                        class="data-cell  m-0 p-0 text-center"
                                        v-if="zeroFills(date, product)">
                                        {{ zeroFills(date, product) }}
                                    </div>
                                    <div class="data-cell  m-0 p-0 text-center text-secondary" v-else>-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">Всего произведено за месяц:</div>
            <div class="card-body">
                <table class="table table-striped col-6">
                    <thead>
                    <tr>
                        <th class="title">Продукция</th>
                        <th class="cells">Количество</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(product, index) of reportData"
                        :key="index"
                        v-if="product.monthlyProduction">
                        <td class="title">
                            {{ product.title }}
                        </td>
                        <td>
                            {{ product.monthlyProduction }} {{ product.unit }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: "ProductionMonth",
    data() {
        return {
            date: new Date(),
            reportData: [],
            localDate: this.commonDate,
            isLoading: ''
        }
    },
    props: {
        commonDate: '',
        dateFormated: {}
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'SET_PROMISE_READY'
        ]),
        datesArray() {
            var result = []
            var i = 0
            while (i < this.daysInMonth().length) {
                i++
                let checkDate = new Date(this.DATE).getFullYear() + '-' + ('0' + (new Date(this.DATE).getMonth() + 1)).slice(-2) + '-' + ('0' + i).slice(-2)
                result.push(checkDate)
            }
            return result
        },
        zeroFills(date, product) {
            for (let produce of product.dailyProduction)
                if (produce.date === date) {
                    return produce.qty
                }
        },
        isWeekend(day) {
            let currentDate = new Date(Date.parse(this.commonDate))
            currentDate.setDate(day);
            let isWeekend = (currentDate.getDay() === 6) || (currentDate.getDay() === 0);    // 6 = Saturday, 0 = Sunday
            return isWeekend
        },
        daysInMonth() {
            // var getDaysArray = function(year, month) {
            const year = new Date(this.commonDate).getFullYear()
            const month = new Date(this.commonDate).getMonth()
            var names = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
            var date = new Date(year, month, 1);
            var result = [];
            while (date.getMonth() == month) {
                result.push({day: date.getDate(), dayName: names[date.getDay()]});
                date.setDate(date.getDate() + 1);
            }
            return result;
            // }

            // let date = new Date(Date.parse(this.commonDate))
            // return new Date(date.getFullYear(),
            //     date.getMonth() + 1,
            //     0).getDate();
        },
        getReport() {
            this.isLoading = true
            this.SET_PROMISE_READY(false)
            axios.get('/api/reports/monthly', {
                headers: {'Content-Type': 'application/json'},
            })
                .then(response => {
                    this.reportData = response.data
                    this.isLoading = false
                    this.SET_PROMISE_READY(true)
                    return response.data
                })
                .then(response => {
                    // console.log(response)
                    return response
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'DATE'
        ]),
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        DATE: function (newLocalDate, oldCLocalDate) {
            this.getReport()
        }
    },
    mounted() {
        this.getReport()
        // this.isWeekend()
    }
}
</script>

<style scoped>
.table-header {
    height: 50px !important;
}

.data-cell {
    width: 50px !important;
}

.horizontal-scrollable {
    overflow-x: auto;
}

.title {
    width: 150px;
    text-align: left;
}

.monthBtn {
    width: 100px;
}
</style>
