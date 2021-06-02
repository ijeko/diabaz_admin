<template>
  <div class="wrapper">
    <div class="card mt-4">
      <div class="card-header">
        Заявки и планирование отгрузок1
          {{orders}}
      </div>
      <div class="card-body">
        <component-loader v-if="isLoading"></component-loader>
        <div class="list-group">
          <a href="#" class="list-group-item list-group-item-action list-group-item-success">
            <div class="d-flex w-100 justify-content-between">
              <h5 class="mb-1">Мука навал</h5>
              <span>66 тн</span>
            </div>
            <div class="d-flex w-100 justify-content-between">
              <p class="mb-1">Промэнергоизоляция</p>
              <small>17-03-2021</small>
            </div>
            <small>Отгрузка в вагоне 66 тонн</small>
          </a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "SoldPlanComponent",
  data() {
    return {
        orders: {},
      isLoading: false,
    }
  },
    methods: {
    },
    mounted() {
    }
}
</script>

<style scoped>

</style>
