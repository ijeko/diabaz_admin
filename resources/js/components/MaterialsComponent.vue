<template>
    <div class="card">
        <div class="card-header">Остатки материалов
        </div>
        <div class="card-body">
            <div class="materials"
                 v-for="(material, index) in MATERIALS"
                 :key="index">
                <div class="material-name">
                    <div>{{ material.title }} <span v-if="material.stock<=material.minQty"
                                                    class="badge badge-pill badge-danger">Мало</span>
                    </div>
                </div>
                <div class="material-qty">{{ material.stock }} {{ material.unit }}</div>
            </div>
        </div>
        <!--        <button class="btn btn-outline-dark" @click="showShowNorm">Нормы расхода</button>-->
        <button v-if="user.role != 'gorny'" class="btn btn-outline-dark" @click="showIncomes">Поступления материалов
        </button>
        <show-norm v-if="isShowNormVisible"
                   @closeShowNorm="closeShowNorm"
        ></show-norm>
        <show-incomes v-if="isIncomesVisible"
                      @closeIncomes="closeIncomes"
                      :date="date"
                      :user="user"
        ></show-incomes>
        <component-loader v-if="isLoading"

        ></component-loader>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import ShowNorm from "./popup/ShowNorm";
import ComponentLoader from "./loaders/componentLoader";

export default {
    name: 'MaterialsComponent',
    components: {ComponentLoader, ShowNorm},
    mounted() {
        this.GET_MATERIALS().then(res => {
           this.isLoading = false
        })
    },
    data: function () {
        return {
            materials: [],
            // date: new Date(),
            isShowNormVisible: false,
            isIncomesVisible: false,
            stock: this.qty,
            isLoading: true
        }
    },
    props: {
        dateFormated: '',
        user: {},
        date: ''
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
            // 'MATERIAL_QTY'
        ]),
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS',
            // 'GET_MATERIAL_QTY'
        ]),
        showShowNorm() {
            return this.isShowNormVisible = true
        },
        closeShowNorm() {
            return this.isShowNormVisible = false
        },
        showIncomes() {
            return this.isIncomesVisible = true
        },
        closeIncomes() {
            this.GET_MATERIALS()
            return this.isIncomesVisible = false
        },
        loading(bool) {
            this.isLoading = bool === true;
        },
        hide() {
            this.isLoading = false
        }
    },
}
</script>
<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
