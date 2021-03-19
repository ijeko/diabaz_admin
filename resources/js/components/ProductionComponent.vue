<template>
    <div class="card">
        <div class="card-header">Произведенная продукция на {{ dateFormated.day }} {{ dateFormated.month }}
            {{ dateFormated.year }}
            <div class="btn btn-link"
                 @mousedown="GET_PRODUCTS(yesterday)"
                 @mouseup="GET_PRODUCTS(currentDate)"
            >Показать за вчера
            </div>
        </div>
        <div class="card-body">
            <div v-if="message" class="alert alert-danger" role="alert">
                Не достаточно материалов:
                <div v-for="(item, index) in message"
                     :key="index"
                >
                    {{ item.title }} - {{ item.qty }}ед.
                </div>
            </div>
            <table>
                <tr>
                    <th>Продукция</th>
                    <th>Произведено</th>
                    <th>Отгружено</th>
                    <th>Склад</th>
                </tr>
                <tr v-for="(product, index) in PRODUCTS"
                    :key="index">
                    <td :class="{'text-secondary' : !product.stock, 'text-success' : product.dayProduced}"
                    >
                        {{ product.title }}
                    </td>
                    <td :class="{'text-secondary' : !product.dayProduced}">
                        {{ product.dayProduced }} {{ product.unit }}
                    </td>
                    <td :class="{'text-secondary' : !product.sold}">
                        {{ product.sold }} {{ product.unit }}
                    </td>
                    <td :class="{'text-secondary' : !product.stock}">
                        {{ product.stock }} {{ product.unit }}
                    </td>
                </tr>
            </table>

        </div>
        <enter-produced
            v-if="isEnterVisible"
            class="popup"
            :products="PRODUCTS"
            :user="user"
            @closePopup="closePopup"
            @sendProduced="sendProduced"
        ></enter-produced>
        <enter-sold
            v-if="isSoldVisible"
            class="popup"
            :products="PRODUCTS"
            :user="user"
            @closeSold="closeSold"
            @sendSold="sendSold"
        ></enter-sold>
        <button class="btn btn-outline-dark" @click="showPopup">+ Произведено</button>
        <button class="btn btn-outline-dark" @click="showSold">+ Отгружено</button>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'ProductionComponent',
    components: {},
    mounted() {
        // this.GET_SOLD(this.date)
        this.GET_PRODUCTS(this.currentDate)
    },
    data: function () {
        return {
            isEnterVisible: '',
            isSoldVisible: false,
            message: ''
        }
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        currentDate: function (newcurrentDate, oldcurrentDate) {
            this.GET_PRODUCTS(this.currentDate)
        }
    },
    props: {
        user: {
            default: ''
        },
        dateFormated: {
            type: Object,
            default: ''
        },
        date: ''

    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
        ]),
        currentDate() {
            var date = {date: this.date}
            this.GET_PRODUCTS(date)
            return date
        },
        yesterday() {
            let currentDate = new Date(Date.parse(this.date))
            currentDate.setDate(currentDate.getDate() - 1);
            // this.GET_PRODUCTS({date: currentDate})
            return {date: currentDate.toISOString().slice(0, 10)}
            // console.log(currentDate.toISOString().slice(0, 10))
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'GET_MATERIAL_QTY',
            'ADD_SOLD',
            'ADD_PRODUCED'
        ]),
        showPopup() {
            this.isEnterVisible = true
        },
        closePopup() {
            this.isEnterVisible = ''
        },
        showSold() {
            this.isSoldVisible = true
        },
        closeSold() {
            this.isSoldVisible = ''
        },
        sendProduced(data) {
            data = JSON.stringify(data)
            // this.ADD_PRODUCED(JSON.stringify(data))
            axios.post('http://127.0.0.1:8000/api/produced/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    // commit('SET_PRODUCED', response.data)
                    this.message = response.data
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            this.GET_PRODUCTS(this.currentDate)
            this.GET_MATERIAL_QTY()
            this.closePopup()
        },
        sendSold(data) {
            this.ADD_SOLD(JSON.stringify(data))
            this.GET_PRODUCTS(this.currentDate)
            this.closeSold()
        }
    }
}
</script>
<style scoped>
table {
    width: 100%;
}

tr {
    /*display: flex;*/
    /*justify-content: space-between;*/
    border-bottom: 1px dotted silver;
}

td {
    width: 25%;
}

td {
    width: 25%;
}
</style>
