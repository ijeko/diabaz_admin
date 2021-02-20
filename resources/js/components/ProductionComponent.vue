<template>
    <div class="card">
        <div class="card-header">Произведенная продукция на {{ dateFormated }}</div>
        <div class="card-body">
            {{currentDate}}
            <table>
                <tr>
                    <th>Продукция</th>
                    <th>Остатки??</th>
                    <th>Произведено сегодня</th>
                </tr>
                <tr v-for="(product, index) in PRODUCTS"
                    :key="index">
                    <td>{{ product.title }}</td>
                    <td>1</td>
                    <td>{{ producedOf(product.id) }}</td>
                </tr>
            </table>
            <div>
                <button class="btn btn-dark" @click="showPopup">Внести данные</button>
            </div>
        </div>
        <enter-produced
            v-if="isEnterVisible"
            class="popup"
            :products="PRODUCTS"
            :user="user"
            @closePopup="closePopup"
            @sendProduced="sendProduced"
        ></enter-produced>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'ProductionComponent',
    components: {},
    mounted() {
        this.GET_PRODUCTS()
        this.GET_PRODUCED(this.currentDate)
    },
    data: function () {
        return {
            isEnterVisible: '',
            produced: {}
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
        date:''

    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'PRODUCED'
        ]),
        currentDate () {
            var  date = {date: this.date}
            this.GET_PRODUCED(date)
            return date
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'GET_PRODUCED',
            'ADD_PRODUCED'
        ]),
        showPopup() {
            this.isEnterVisible = true
        },
        closePopup() {
            this.isEnterVisible = ''
        },
        sendProduced(data) {
            this.ADD_PRODUCED(JSON.stringify(data))
            console.log(data)
            this.GET_PRODUCED(this.currentDate)
            this.closePopup()
        },
        producedOf: function (prd_id) {
            var p = []

            for (var prod of this.PRODUCED) {
                if (prod.product_id === prd_id) {
                    return prod.qty
                }
            }
        }
    }
}
</script>
<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}

td {
    width: 25%;
}
</style>
