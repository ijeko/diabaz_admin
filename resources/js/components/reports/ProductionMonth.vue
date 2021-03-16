<template>
    <div class="card mt-4">
        <div class="card-header">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <label class="input-group-text" for="inputGroupSelect01">Произведено за</label>
                </div>
                <select class="custom-select" id="inputGroupSelect01">
                    <option selected>этот месяц</option>
                    <option value="1">январь</option>
                    <option value="2">февраль</option>
                    <option value="3">Three</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th class="title">Продукция</th>
                    <th class="cells"
                        v-for="day in daysInMonth()"
                        :key="day">{{ day }}
                    </th>
                </tr>
                <tr v-for="(product, index) in reportData"
                    :key="index"
                    v-if="product.daily.reduce(function(sum, elem) {
               return sum + elem
                    }, 0)>0"
                >
                    <td class="title">
                        {{ product.title }} ({{ product.unit }})
                    </td>
                    <td class="cells"
                        v-for="(dayProduced, index) in product.daily"
                        :key="index"
                        :class="{ 'bg-success produced': dayProduced }"
                    >{{ dayProduced }}
                    </td>
                </tr>
            </table>
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
            reportData: []
        }
    },
    props: {
        commonDate: ''
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
        daysInMonth() {
            return new Date(this.date.getFullYear(),
                this.date.getMonth() + 1,
                0).getDate();
        },
        test() {
            let data = {date: this.commonDate, days: this.daysInMonth()}
            axios.get('http://127.0.0.1:8000/api/products/test', {
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
        commonDate: function (newCommonDate, oldCommonDate) {
            this.test()
        }
    },
    mounted() {
        this.test()
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
    background-color: whitesmoke;
}
td:hover {
    /*border-inline: 1px solid #1f6fb2;*/
    background-color: whitesmoke;
}
.cells {
    width: 2.9%;
    border-left: 1px solid silver;
    border-right: 1px solid silver;
}

.title {
    width: 50px;
    text-align: left;
}
</style>
