<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">
                <!--            {{ Date.parse(localDate) }}-->
                Произведено продукции за {{dateFormated.ofMonth}} {{dateFormated.year}}
            </div>
            <div class="card-body">
                <component-loader v-if="isLoading"></component-loader>
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="title">Продукция</th>
                            <th class="cells text-dark"
                                v-for="day in daysInMonth()"
                                :key="day"
                                :class="{'bg-warning': isWeekend(day) }">
                                {{ day }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in reportData"
                            :key="index"
                        >
<!--                            v-if="product.dailyProduction.qty.reduce(function(sum, elem) {-->
<!--                            return sum + elem-->
<!--                            }, 0)>0"-->
                            <td class="title">
                                {{ product.title }} ({{ product.unit }})
                            </td>
                            <td class="cells"
                                v-for="(dayProduced, index) in product.dailyProduction"
                                :key="index"
                                :class="{ 'bg-success produced': dayProduced, 'text-secondary': !dayProduced }"
                            >{{ dayProduced.qty }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            'GET_PRODUCTS'
        ]),
        isWeekend (day) {
            let currentDate = new Date(Date.parse(this.commonDate))
            currentDate.setDate(day);
            let isWeekend = (currentDate.getDay() === 6) || (currentDate.getDay() === 0);    // 6 = Saturday, 0 = Sunday
            return isWeekend
        },
        daysInMonth() {
            let date = new Date(Date.parse(this.localDate))
            return new Date(date.getFullYear(),
                date.getMonth() + 1,
                0).getDate();
        },
        getReport() {
            this.isLoading = true
            axios.get('/api/reports/monthly', {
                headers: {'Content-Type': 'application/json'},
                // params: data
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
        }
    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
        ]),
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        commonDate: function (newLocalDate, oldCLocalDate) {
            this.getReport()
        }
    },
    mounted() {
        this.getReport()
        this.isWeekend()
    }
}
</script>

<style scoped>
table {
    width: 100%;
}

td, th {
    padding: 2px;
    text-align: center;
}

tr {
    border: 1px solid transparent;
}

tr:hover {
    /*border-inline: 1px solid #1f6fb2;*/
    /*background-color: whitesmoke;*/
}

td:hover {
    /*border-inline: 1px solid #1f6fb2;*/
    /*background-color: whitesmoke;*/
}

.cells {
    width: 2.9%;
    /*border-left: 1px solid silver;*/
    /*border-right: 1px solid silver;*/
}

.title {
    width: 150px;
    text-align: left;
}

.monthBtn {
    width: 100px;
}
</style>
