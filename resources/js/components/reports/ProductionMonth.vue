<template>
    <div>
        <div class="card mt-4">
            <div class="card-header">
                <!--            {{ Date.parse(localDate) }}-->
                Произведено продукции за месяц:
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
                <div class="table-responsive text-nowrap">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="title">Продукция</th>
                            <th class="cells text-dark"
                                v-for="day in daysInMonth()"
                                :key="day"
                                :class="{'bg-warning': isWeekend(day) }"
                            >{{ day }}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(product, index) in reportData"
                            :key="index"
                            v-if="product.daily.reduce(function(sum, elem) {
                                                return sum + elem
                                                 }, 0)>0">
                            <td class="title">
                                {{ product.title }} ({{ product.unit }})
                            </td>
                            <td class="cells"
                                v-for="(dayProduced, index) in product.daily"
                                :key="index"
                                :class="{ 'bg-success produced': dayProduced, 'text-secondary': !dayProduced }"
                            >{{ dayProduced }}
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
                    <tr v-for="(product, index) in reportData"
                        :key="index"
                        v-if="product.daily.reduce(function(sum, elem) {
                                            return sum + elem
                                            }, 0)>0">
                        <td class="title">
                            {{ product.title }}
                        </td>
                        <td>
                            {{ product.monthly }} {{ product.unit }}
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
        isWeekend (day) {
            let currentDate = new Date(Date.parse(this.localDate))
            currentDate.setDate(day);
            var isWeekend = (currentDate.getDay() === 6) || (currentDate.getDay() === 0);    // 6 = Saturday, 0 = Sunday
            return isWeekend
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
            axios.get('/api/reports/monthly', {
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
