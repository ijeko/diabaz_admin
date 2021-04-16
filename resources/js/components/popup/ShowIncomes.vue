<template>
    <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Поступление материалов за {{ FORMATED_DATE.ofMonth }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeIncomes" >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="list-group">
                        <div  class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
                            <span class="w-25 text-center">Материал</span>
                            <span class="w-25 text-center">Количество</span>
                        </div>
                    </div>
                    <div class="list-group overflow-auto mat">
                        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                           v-for="(material, index) in INCOMES"
                           :key="index"
                        >
                            <span class="w-25 text-left">{{material.title}}</span>
                            <span class="w-25 text-center">{{ material.monthlyIncome }} {{ material.unit }}</span>
                        </a>
                    </div>





                </div>
                <div class="modal-footer">
<!--                    <button type="button" class="btn btn-primary" @click="sendMotohour" data-dismiss="modal">Сохранить</button>-->
<!--                    <button type="button" class="btn btn-secondary" data-dismiss="modal" @click="closePopup">Закрыть</button>-->
                </div>
            </div>
        </div>
    </div>
<!--    <div class="wrapper">-->
<!--        <div class="text-right" @click="closeIncomes">&times;</div>-->
<!--        <h3 class="text-center mb-4">Поступление материалов на дату</h3>-->
<!--        <input type="date" v-model="localDate" @input="showIncomesOnDate" class="form-control">-->
<!--        <div class="incomeItem" v-for="item in INCOMES"-->
<!--             :key="item.id"-->
<!--        >-->
<!--            <div class="normTitle"> {{item.title }}</div>-->
<!--            <div class="normValue">{{ item.qty }} {{ item.unit }}</div>-->
<!--            <div class="del" @click="remove(item.id)">&times;</div>-->
<!--        </div>-->
<!--        <button class="btn btn-outline-success mt-4" style="width: 100%" @click="showAddForm">-->
<!--            Новое поступление-->
<!--        </button>-->
<!--        <button class="btn btn-outline-danger mt-2" style="width: 100%" @click="closeIncomes">Закрыть</button>-->
<!--        <add-income-form v-if="isAddIncomesVisible"-->
<!--                         @closeAddForm="closeAddForm"-->
<!--                         @update="showIncomesOnDate"-->
<!--                         :user="user"-->
<!--        ></add-income-form>-->
<!--    </div>-->

</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
    name: "Incomes",
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
            'FORMATED_DATE',
            'INCOMES'
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
            this.GET_INCOMES()
        },
        materialById(id)
        {
                var title = this.MATERIALS.find(material => material.id === id)
                var unit = this.MATERIALS.find(material => material.id === id)
            if (title && unit)
            {
                let data = {title: title.title, unit: unit.unit}
                return data
            }
            else return false
        },
        remove (id) {
            axios.delete('/api/incomes/remove',
                {
                    headers: {'Content-Type': 'application/json'},
                    params: {id: id}
                })
                .then(function (response) {
                    return data
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            this.GET_INCOMES()
        }
    },
    mounted() {
      this.GET_INCOMES()
    },
}
</script>

<style scoped>
.mat {
    height: 500px;
}
</style>
