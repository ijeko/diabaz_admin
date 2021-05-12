<template>
  <div class="test">
    <month-selector-component></month-selector-component>
    <div class="row justify-content-between">
      <div class="col-md-3">
        <div class="mt-4">
          <div class="btn-group-vertical">
            <button type="button"
                    class="btn btn-secondary text-left">
              <router-link :to="{ name: 'orders' }">
                <span class="btn-text">Заявки</span>
              </router-link>
            </button>
            <button type="button"
                    class="btn btn-secondary text-left">
              <router-link :to="{ name: 'soldPlans' }">
                <span class="btn-text">Планирование отгрузок</span>
              </router-link>
            </button>
            <button type="button"
                    class="btn btn-secondary text-left">
              <router-link :to="{ name: 'productUpload' }">
                <span class="btn-text">Планирование производства</span>
              </router-link>
            </button>
            <button type="button"
                    class="btn btn-secondary text-left">
              <router-link :to="{ name: 'productUpload' }">
                <span class="btn-text">Планирование материалов</span>
              </router-link>
            </button>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <router-view
            :commonDate="DATE"
            :dateFormated="FORMATED_DATE"
            :key="UPDATE"
        ></router-view>
      </div>
    </div>
  </div>
</template>
<script>

import {mapGetters} from 'vuex'

export default {
  name: "PlanWrapperComponent",
  data: function () {
    return {
      date: new Date().toISOString().slice(0, 10)
    }
  },
  props: {
    user: {
      default: ''
    }
  },
  computed: {
    ...mapGetters([
      'DATE',
      'UPDATE',
      'FORMATED_DATE',
    ])
  },
  methods: {}
}
</script>

<style scoped>
.btn-text {
  text-decoration: none;
  color: white !important;
}
</style>
