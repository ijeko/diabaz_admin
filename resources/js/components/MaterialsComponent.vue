<template>
    <div class="card">
        <div class="card-header">Остатки материалов</div>
        <div class="card-body ">
          <div class="list-group">
            <div  class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
              <span class="w-50 text-center">Материалы</span>
              <span class="w-50 text-center">Остатки</span>
            </div>
          </div>
          <div class="list-group overflow-auto mat">
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
               :class="{ 'list-group-item-danger': material.stock<=material.minQty}"
               v-for="(material, index) in MATERIALS"
               :key="index"
            ><span>{{material.title}}</span><span>{{ material.stock }} {{ material.unit }}</span></a>

          </div>
        </div>
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
.mat {
  height: 400px;
}
</style>
