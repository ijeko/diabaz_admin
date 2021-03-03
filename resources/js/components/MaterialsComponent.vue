<template>
    <div class="card">
        <div class="card-header">Данные по материалам на {{ dateFormated.day }} {{ dateFormated.month }} {{ dateFormated.year }}г.</div>
        <div class="card-body">
            <div class="materials"
                 v-for="(material, index) in MATERIALS"
                 :key="index">
                <div class="material-name">
                    <div>{{ material.title }}
                    </div>
                </div>
                <div class="material-qty">{{ MATERIAL_QTY.totalIncomes[index].qty - MATERIAL_QTY.totalUsed[index].qty }} {{ material.unit }}</div>
            </div>
        </div>
        <button class="btn btn-outline-dark" @click="showShowNorm">Нормы расхода</button>
        <button class="btn btn-outline-dark" @click="showIncomes">Поступления материалов</button>
        <show-norm v-if="isShowNormVisible"
        @closeShowNorm="closeShowNorm"
        ></show-norm>
        <show-incomes v-if="isIncomesVisible"
        @closeIncomes="closeIncomes"
                      :date="date"
                      :user="user"
        ></show-incomes>
    </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import ShowNorm from "./popup/ShowNorm";
export default {
    name: 'MaterialsComponent',
    components: {ShowNorm},
    mounted() {
        console.log('Component mounted.')
        this.GET_MATERIALS()
        this.GET_MATERIAL_QTY()


    },
    data: function () {
        return {
            // date: new Date(),
            isShowNormVisible: false,
            isIncomesVisible: false
        }
    },
    props: {
        dateFormated: '',
        user: '',
        date:''
    },
    computed: {
        ...mapGetters([
            'MATERIALS',
            'MATERIAL_QTY'
        ]),
        qty () {
            let qty = []
            let i = 0
            for (let item in this.MATERIAL_QTY.length) {
                i++
                qty.push(item.totalIncomes[i].qty - item.totalUsed[i].qty)
                console.log(item)
            }
            return qty
        }
    },
    methods: {
        ...mapActions([
            'GET_MATERIALS',
            'GET_MATERIAL_QTY'
        ]),
        showShowNorm () {
            return this.isShowNormVisible = true
        },
        closeShowNorm () {
            return this.isShowNormVisible = false
        },
        showIncomes () {
            return this.isIncomesVisible = true
        },
        closeIncomes () {
            return this.isIncomesVisible = false
        },
    }
}
</script>
<style scoped>
.materials {
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
</style>
