<template>
  <div class="card">
    <div class="card-header">{{ stockIncomesText.title }} <span
        v-if="!stockIncomes">{{ FORMATED_DATE.ofMonth }} {{ FORMATED_DATE.year }}</span></div>
    <div v-if="stockIncomes" class="card-body">
      <div class="list-group">
        <div class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
          <span class="w-50 text-center">Материалы</span>
          <span class="w-50 text-center">Остатки</span>
        </div>
      </div>
      <div class="list-group overflow-auto mat">
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
           :class="{ 'list-group-item-danger': material.stock<=material.minQty}"
           v-for="(material, index) in MATERIALS"
           :key="index"
        ><span>{{ material.title }}</span><span>{{ material.stock }} {{ material.unit }}</span></a>

      </div>
    </div>
    <div v-else class="card-body">
      <div class="list-group">
        <div class="list-group-item list-group-item-secondary d-flex justify-content-between align-items-center">
          <span class="w-25 text-center">Материал</span>
          <span class="w-25 text-center">Количество</span>
        </div>
      </div>
      <div class="list-group overflow-auto mat">
        <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
           v-for="(material, index) in INCOMES"
           :key="index"
        >
          <span class="w-25 text-left">{{ material.title }}</span>
          <span class="w-25 text-center">{{ material.monthlyIncome }} {{ material.unit }}</span>
        </a>
      </div>
    </div>
    <div class="btn-group-vertical" role="group" aria-label="Basic example">
      <button type="button"
              class="btn btn-outline-primary"
              @click="stockIncomeSwitcher()"
      >{{ stockIncomesText.button }}
      </button>
      <button type="button"
              class="btn btn-outline-primary"
              data-toggle="modal"
              data-target="#staticBackdrop"
              @click=""
      >Добавить поступление
      </button>
    </div>
    <add-incomes v-if="showAddIncome"
                 @closeIncomes="showHideAddIncome"
                 :date="date"
                 :user="user"
                 @update="update"
    ></add-incomes>
    <component-loader v-if="isLoading"

    ></component-loader>
  </div>
</template>

<script>
import {mapGetters, mapActions} from 'vuex'
import ComponentLoader from "./loaders/componentLoader";

export default {
  name: 'MaterialsComponent',
  components: {ComponentLoader},
  mounted() {
    this.GET_MATERIALS().then(res => {
      this.isLoading = false
    })
    this.GET_INCOMES(this.DATE).then(res => {
      this.isLoading = false
    })
  },
  data: function () {
    return {
      materials: [],
      stockIncomes: true,
      showAddIncome: true,
      // date: new Date(),
      isShowNormVisible: false,
      isIncomesVisible: false,
      stock: this.qty,
      isLoading: true
    }
  },
  // watch: {
  //   DATE(newDATE, oldDATE) {
  //     this.GET_INCOMES()
  //   }
  // },
  props: {
    user: {},
    date: ''
  },
  computed: {
    ...mapGetters([
      'MATERIALS',
      'INCOMES',
      'DATE',
      'FORMATED_DATE'
    ]),
    stockIncomesText() {
      if (!this.stockIncomes)
        return {title: 'Поступление материалов за ', button: 'Остатки материалов'}
      else
        return {title: 'Остатки материвалов', button: 'Поступление материалов'}

    }
  },
  methods: {
    ...mapActions([
      'GET_MATERIALS',
      'GET_INCOMES'
    ]),
    showHideAddIncome() {
      this.showAddIncome = this.showAddIncome !== true;
    },
    stockIncomeSwitcher() {
      this.stockIncomes = this.stockIncomes !== true;
    },
    loading(bool) {
      this.isLoading = bool === true;
    },
    hide() {
      this.isLoading = false
    },
    update() {
      this.GET_MATERIALS()
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
