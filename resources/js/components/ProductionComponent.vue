<template>
    <div class="card">
        <div class="card-header">Произведенная продукция</div>
        <div class="card-body">
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
                    <td>{{  }}</td>
                </tr>
            </table>
            <div>
                <button class="btn btn-dark" @click="showPopup">Внести данные</button>
            </div>
        </div>
        <enter-produced
            v-if="isEnterVisible"
            class="popup"
            :products="products"
            @closePopup="closePopup"
        ></enter-produced>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'MaterialsComponent',
    components: {},
    mounted() {
        this.GET_PRODUCTS(this.products)
        console.log('this.test')
    },
    data: function () {
        return {
            date: new Date(),
            isEnterVisible: ''
        }
    },
    props: {
        products: {
            default: []
        },
        test: {
            default: ''
        }

    },
    computed: {
        ...mapGetters([
            'PRODUCTS',
            'PRODUCED'
        ]),
        dateFormated() {
            var day = this.date.getDate()
            var mnths = ['января', 'февраля', 'марта', 'апреля', 'июля', 'июня', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
            var month = mnths[this.date.getMonth()]
            var year = this.date.getFullYear()
            return {day: day, month: month, year: year}
        },
        localProduced () {
            for (produced of this.PRODUCED) {
            }
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'GET_PRODUCED'
        ]),
        showPopup() {
            this.isEnterVisible = true
        },
        closePopup() {
            this.isEnterVisible = ''
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
