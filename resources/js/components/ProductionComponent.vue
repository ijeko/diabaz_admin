<template>
    <div class="card">
        <div class="card-header">Произведенная продукция за {{ FORMATED_DATE.ofMonth }}
            {{ FORMATED_DATE.year }} года
        </div>
        <div v-if="message"
             class="alert alert-danger"
             role="alert"
             @click="message => {this.message=''}"
        >
            {{ message.error}}
            <div v-for="(item, index) in message.data"
                 :key="index"
            >
                {{ item.title }} - {{ item.qty }} {{ item.unit }}
            </div>
        </div>
        <div class="card-body ">
            <div class="list-group">
                <div
                    class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                    <span class="w-25 text-left">Продукция</span>
                    <span class="w-25 text-center">Произведено</span>
                    <span class="w-25 text-center">Отгружено</span>
                    <span class="w-25 text-center">Остатки</span>
                </div>
            </div>
            <div class="list-group overflow-auto mat">
                <a href="#"
                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                   :class="{'text-secondary' : !product.stock, 'list-group-item-success' : product.monthlyProduction}"
                   v-for="(product, index) in PRODUCTS"
                   :key="index"
                >
                    <span class="w-25 text-left">{{ product.title }}</span>
                    <span class="w-25 text-center">{{ product.monthlyProduction }} {{ product.unit }}</span>
                    <span class="w-25 text-center">{{ product.monthlySold }} {{ product.unit }}</span>
                    <span class="w-25 text-center">{{ product.stock }} {{ product.unit }}</span>
                </a>
            </div>
        </div>
        <component-loader v-if="isLoading"></component-loader>
        <enter-produced
            v-if="isEnterVisible"
            class="popup"
            :user="user"
            @closePopup="closePopup"
            @sendProduced="sendProduced"
            @sendSpoiled="sendSpoiled"
        ></enter-produced>
        <enter-sold
            v-if="isSoldVisible"
            class="popup"
            :user="user"
            @closeSold="closeSold"
            @sendSold="sendSold"
        ></enter-sold>
        <div class="btn-group-vertical" role="group" aria-label="Basic example">
            <button type="button"
                    class="btn btn-outline-primary"
                    data-toggle="modal"
                    data-target="#exampleModal"
                    @click="showPopup"
            >Добавить производство
            </button>
            <button v-if="user.role != 'gorny'"
                    class="btn btn-outline-primary"
                    data-toggle="modal"
                    data-target="#sold"
                    @click="showSold"
            >Добавить отгрузку
            </button>
        </div>
    </div>
</template>

<script>

import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'ProductionComponent',
    components: {},
    mounted() {
        this.GET_PRODUCTS({currentDate: this.DATE})
            .then(response => {
                this.SET_PROMISE_READY(true)
                this.isLoading = false
                return response
            })
    },
    data: function () {
        return {
            products: '',
            isEnterVisible: '',
            isSoldVisible: false,
            message: '',
            errorProduced: '',
            isLoading: true
        }
    },
    props: {
        user: {
            default: {}
        },
        date: ''

    },
    computed: {
        ...mapGetters([
            `PRODUCTS`,
            `DATE`,
            'FORMATED_DATE',
        ]),
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS',
            'ADD_SOLD',
            'ADD_PRODUCED',
            'UPDATE_KEY',
            'SET_PROMISE_READY'
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
        action() {
            this.isLoading = true
            this.SET_PROMISE_READY(false)
            this.closePopup()
            this.closeSold()
            this.UPDATE_KEY()
        },
        sendProduced(data) {
            axios.post('/api/produced/add',
                {data},
                {
                    headers: {'Content-Type': 'application/json'}
                })
                .then(response => {
                    this.action()
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
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
                    this.action()
                    this.message = response.data
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data

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
                    return response.data
                })
                .catch(error => {
                    this.message = error.response.data
                })
        }
    }
}
</script>
<style scoped>
.mat {
    height: 400px;
}
</style>
