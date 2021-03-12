<template>
    <div class="card">
        <div class="card-header">Произведенная продукция на {{ dateFormated.day }} {{ dateFormated.month }}
            {{ dateFormated.year }}
        </div>
        <div class="card-body">
            <table>
                <tr>
                    <th>Продукция</th>
                    <th>Произведено</th>
                    <th>Отгружено</th>
                    <th>Склад</th>
                </tr>
                <tr v-for="(product, index) in PRODUCTS"
                    :key="index">
                    <td>
                        {{ product.title }}
                    </td>
                    <td>
                        {{ producedOf(product.id) }} <span v-if="!producedOf(product.id)">0</span> {{ product.unit }}
                    </td>
                    <td>
                        {{ soldOf(product.id) }} {{ product.unit }}
                    </td>
                    <td>
                        {{ stockOf(product.id) }} {{ product.unit }}
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
        this.GET_PRODUCTS()
        this.GET_PRODUCED(this.date)
        this.GET_STOCK(1)
    },
    data: function () {
        return {
            isEnterVisible: '',
            produced: {},
            isSoldVisible: false
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
            'PRODUCED',
            'SOLD',
            'STOCK'
        ]),
        currentDate() {
            var date = {date: this.date}
            this.GET_PRODUCED(date)
            this.GET_SOLD(date)
            this.GET_STOCK()
            return date
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'GET_PRODUCED',
            'ADD_PRODUCED',
            'GET_SOLD',
            'ADD_SOLD',
            'GET_STOCK'
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
            this.ADD_PRODUCED(JSON.stringify(data))
            console.log(data)
            this.GET_PRODUCED(this.currentDate)
            this.GET_STOCK()
            this.closePopup()
        },
        sendSold(data) {
            this.ADD_SOLD(JSON.stringify(data))
            console.log(data)
            this.GET_SOLD(this.currentDate)
            this.GET_STOCK()
            this.closeSold()
        },
        producedOf: function (prd_id) {
            this.currentDate
            for (var prod of this.PRODUCED) {
                if (prod.product_id === prd_id) {
                    return prod.qty
                }
            }
        },
        soldOf: function (prd_id) {
            this.currentDate
            for (var prod of this.SOLD) {
                if (prod.product_id === prd_id) {
                    return prod.qty
                }
            }
        },
        stockOf: function (prd_id) {
            this.currentDate
            for (var prod of this.STOCK) {
                if (prod.product_id === prd_id) {
                    return prod.qty
                }
            }
        }
    }
}
</script>
<style scoped>
tr {
    /*display: flex;*/
    /*justify-content: space-between;*/
    border-bottom: 1px dotted silver;
}

td {
    width: 25%;
}
</style>
