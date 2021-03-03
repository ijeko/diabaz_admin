<template>
    <div class="wrapper">
<!--         обновление при смене даты (может через креатед-->
        <div class="text-right" @click="closeIncomes">&times;</div>
        <h3 class="text-center mb-4">Поступление материалов на дату</h3>
        <input type="date" v-model="localDate" @input="showIncomesOnDate">
        <div class="incomeItem" v-for="item in INCOMES"
             :key="item.id"
        >
            <div class="normTitle"> {{ MATERIALS[item.material_id-1].title }}</div>
            <div class="normValue">{{ item.qty }} {{ MATERIALS[item.material_id-1].unit }}</div>
            <div class="del" @click="remove(item.id)">&times;</div>
        </div>

        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="showAddForm">
            Новое поступление
        </button>
        <button class="btn btn-outline-danger mt-2" style="width: 100%" @click="closeIncomes">Закрыть</button>
        <add-income-form v-if="isAddIncomesVisible"
                         @closeAddForm="closeAddForm"
                         :user="user"
        ></add-income-form>
    </div>

</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import AddIncomeForm from "./AddIncomeForm";

export default {
    name: "Incomes",
    components: {AddIncomeForm},
    data() {
        return {
            isAddIncomesVisible: false,
            isSelected: false,
            localNorm: '',
            selectProd: '',
            norma: '',
            localDate: this.date
        }
    },
    props: {
        date: '',
        user: ''
    },
    computed: {
        ...mapGetters([
            'INCOMES',
            'MATERIALS'
        ]),

    },
    methods: {
        ...mapActions([
            'GET_INCOMES'
        ]),
        closeIncomes() {
            this.$emit('closeIncomes')
        },
        showAddForm() {
            this.isAddIncomesVisible = true
        },
        closeAddForm() {
            this.isAddIncomesVisible = false
        },
        showIncomesOnDate() {
            this.GET_INCOMES({date: this.localDate})
        }
    },
    mounted() {
        this.GET_INCOMES({date: this.localDate})
    }
}
</script>

<style scoped>
.wrapper {
    width: 500px;
    height: auto;
    position: absolute;
    top: 50px;
    left: 50%;
    z-index: 1;
    background-color: white;
    border: 2px solid black;
    padding: 10px;
}

.incomeItem {
    margin-top: 5px;
    display: flex;
    justify-content: space-between;
    border-bottom: 1px dotted silver;
}
.del {
    background-color: rosybrown;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    color: white;
    text-align: center;
    /*font-size: 18px;*/
    vertical-align: middle;
}
.del:hover {
    background-color: red;
    cursor: pointer;
}
.normTitle, .normValue {
    width: 45%;
}
.normValue {
    text-align: right;
}
</style>
