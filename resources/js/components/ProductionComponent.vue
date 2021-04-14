<template>
    <div class="card">
        <div class="card-header">Произведенная продукция за {{ dateFormated.ofMonth }}
            {{ dateFormated.year }}
            <!--            <div class="btn btn-link btn-sm"-->
            <!--                 @mousedown="GET_PRODUCTS(yesterday)"-->
            <!--                 @mouseup="GET_PRODUCTS(currentDate)"-->
            <!--            >Показать за вчера-->
            <!--            </div>-->
        </div>
<!--        <div class="card-body">-->
            <div v-if="message" class="alert alert-danger" role="alert">
                {{message.error}}
                <div v-for="(item, index) in message.data"
                     :key="index"
                >
                    {{ item.title }} - {{ item.qty }}ед. {{errorProduced}}
                </div>
            </div>
          <div class="card-body ">
            <div class="list-group">
              <div  class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                <span class="w-25 text-left">Продукция</span>
                <span class="w-25 text-center">Произведено</span>
                <span class="w-25 text-center">Отгружено</span>
                <span class="w-25 text-center">Остатки</span>
              </div>
            </div>
            <div class="list-group overflow-auto mat">
              <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                 :class="{'text-secondary' : !product.stock, 'list-group-item-success' : product.monthlyProduction}"
                 v-for="(product, index) in PRODUCTS"
                 :key="index"
              >
                <span class="w-25 text-left">{{product.title}}</span>
                <span class="w-25 text-center">{{ product.monthlyProduction }} {{ product.unit }}</span>
                <span class="w-25 text-center">{{ product.monthlySold }} {{ product.unit }}</span>
                <span class="w-25 text-center">{{ product.stock }} {{ product.unit }}</span>
              </a>
            </div>
          </div>
<!--            <table>-->
<!--                <tr>-->
<!--                    <th>Продукция</th>-->
<!--                    <th>Произведено</th>-->
<!--                    <th>Отгружено</th>-->
<!--                    <th>Склад</th>-->
<!--                </tr>-->
<!--                <tr v-for="(product, index) in PRODUCTS"-->
<!--                    :key="index">-->
<!--                    <td :class="{'text-secondary' : !product.stock, 'bg-success' : product.monthlyProduction}"-->
<!--                    >-->
<!--                        {{ product.title }}-->
<!--                    </td>-->
<!--                    <td :class="{'text-secondary' : !product.monthlyProduction}">-->
<!--                        {{ product.monthlyProduction }} {{ product.unit }}-->
<!--                    </td>-->
<!--                    <td :class="{'text-secondary' : !product.monthlySold}">-->
<!--                        {{ product.monthlySold }} {{ product.unit }}-->
<!--                    </td>-->
<!--                    <td :class="{'text-secondary' : !product.stock}">-->
<!--                        {{ product.stock }} {{ product.unit }}-->
<!--                    </td>-->
<!--                </tr>-->
<!--            </table>-->
            <component-loader v-if="isLoading"></component-loader>
<!--        </div>-->
        <enter-produced
            v-if="isEnterVisible"
            class="popup"
            :products="PRODUCTS"
            :user="user"
            @closePopup="closePopup"
            @sendProduced="sendProduced"
            @sendSpoiled="sendSpoiled"
        ></enter-produced>
        <enter-sold
            v-if="isSoldVisible"
            class="popup"
            :products="PRODUCTS"
            :user="user"
            @closeSold="closeSold"
            @sendSold="sendSold"
        ></enter-sold>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" @click="showPopup">+ Произведено</button>
        <button v-if="user.role != 'gorny'" class="btn btn-outline-dark" @click="showSold">+ Отгружено</button>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'ProductionComponent',
    components: {},
    mounted() {
        // this.GET_SOLD(this.date)
        this.action()
    },
    data: function () {
        return {
            isEnterVisible: '',
            isSoldVisible: false,
            message: '',
            errorProduced: '',
            isLoading: true
        }
    },
    watch: {
        // эта функция запускается при любом изменении вопроса
        DATE: function (newcurrentDate, oldcurrentDate) {
            this.action()
        }
    },
    props: {
        user: {
            default: {}
        },
        dateFormated: {
            type: Object,
            default: ''
        },
        date: ''

    },
    computed: {
        ...mapGetters([
            `PRODUCTS`,
            `DATE`
        ]),
        // currentDate() {
        //     var date = {date: this.date}
        //     this.GET_PRODUCTS(date).then(res => {
        //         this.isLoading = false
        //     })
        //     this.$emit('setDate', this.date)
        //     return date
        // },
        // yesterday() {
        //     let currentDate = new Date(Date.parse(this.date))
        //     currentDate.setDate(currentDate.getDate() - 1);
        //     return {date: currentDate.toISOString().slice(0, 10)}
        // }
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
        action () {
            this.isLoading = true
            return this.GET_PRODUCTS({date: this.DATE}).then(res => {
                this.isLoading = false
            })
        },
        sendProduced(data) {
            data = JSON.stringify(data)
            axios.post('/api/produced/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    // commit('SET_PRODUCED', response.data)
                    this.message = response.data
                    this.action()
                    this.closePopup()
                    return response.data
                })
                .catch(response => {
                    console.log(response.message);
                })

        },
        sendSpoiled(data) {
            data = JSON.stringify(data)
            axios.post('/api/products/spoiled/',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    // commit('SET_PRODUCED', response.data)
                    this.message = response.data
                    this.action()
                    this.closePopup()
                    return response.data
                })
                .catch(response => {
                    console.log(response.message);
                })

        },
        sendSold(data) {
            data = JSON.stringify(data)
            axios.post('/api/products/sold',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.message = response.data
                    this.action()
                    this.closeSold()
                    return response.data
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
}
</script>
<style scoped>
/*table {*/
/*    width: 100%;*/
/*}*/

/*tr {*/
/*    !*display: flex;*!*/
/*    !*justify-content: space-between;*!*/
/*    border-bottom: 1px dotted silver;*/
/*}*/

/*td {*/
/*    width: 25%;*/
/*}*/

/*td {*/
/*    width: 25%;*/
/*}*/
.mat {
  height: 400px;
}
</style>
