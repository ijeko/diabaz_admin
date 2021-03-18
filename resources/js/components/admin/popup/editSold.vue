<template>
    <div class="wrapper">
        <div class="card">
            <div class="card-header">
                {{selectedProduct}}
                Отгрузки за месяц
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
                <select class="form-control"
                        v-model="selectedProduct"
                        name="products"
                        id="products"
                        @change="getReport"
                >
                    <option
                    v-for="(product, index) in PRODUCTS"
                    :key="product.id"
                    :value="product.id"
                    >
                        {{product.title}}
                    </option>
                </select>
                <div class="list">
                    <div class="container">
                        <div class="row" v-if="selectedProduct"
                             v-for="upload in uploads"
                             :key="upload.id">
                            <div class="container d-inline-flex listItem justify-content-start">
                                <div class="date">{{upload.date}}</div>
                                <div class="product text-nowrap">{{PRODUCTS.find(x => x.id === upload.product_id).title}}</div>
                                <div class="client">{{upload.soldTo}}</div>
                                <div class="qty">{{ upload.qty }} {{ PRODUCTS.find(x => x.id === upload.product_id).unit }}</div>
                                <div class="action">удалить</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'

export default {
    name: "editSold",
    props: {
        dateFormated: '',
        user: '',
        // date:''
        commonDate: '',
    },
    data () {
        return {
            date: new Date(),
            uploads: [],
            localDate: this.commonDate,
            clientsUpload: [],
            lineToggle: 0,
            selectedProduct: ''
        }
    },
    methods: {
        ...mapActions([
            'GET_PRODUCTS'
        ]),
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
        getReport() {
            let data = {date: this.localDate, product: this.selectedProduct }
            axios.get('http://127.0.0.1:8000/api/products/admin/editsold', {
                headers: {'Content-Type': 'application/json'},
                params: data
            })
                .then(response => {
                    this.uploads = response.data
                    return response.data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
        },
    },
    computed: {
        ...mapGetters([
            'PRODUCTS'
        ])
    },
    mounted() {
        this.GET_PRODUCTS()
    }
}
</script>

<style scoped>
.wrapper {
    width: auto;
    height: auto;
    position: absolute;
    top: 30%;
    right: 25%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.listItem > div {
    margin-right: 10px;
    width: 100px;
}
</style>
