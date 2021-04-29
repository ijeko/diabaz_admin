<template>
  <div>
    <canvas id="myChart" width="400" height="200"></canvas>
  </div>
</template>

<script>
import {Chart, registerables} from 'chart.js';
import {mapActions} from 'vuex';

Chart.register(...registerables);

export default {
  name: "ReportsPage",
  data() {
    return {
      isLoading: false
    }
  },
  methods: {
    ...mapActions([
      'SET_PROMISE_READY'
    ]),
    myChart(produced, sold) {
      return new Chart(this.ctx, {
        type: 'bar',
        data: {
          labels: ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь'],
          datasets: [{
            label: 'Произведено продукции, т',
            data: produced,
            backgroundColor: [
              'rgba(31,113,241, 0.2)',
            ],
            borderColor: [
              'rgb(31,113,241)',

            ],
            borderWidth: 1
          },
            {
              label: 'Отгружено продукции, т',
              data: sold,
              backgroundColor: [
                'rgba(69,163,4,0.2)',
              ],
              borderColor: [
                'rgb(69,163,4)',

              ],
              borderWidth: 1
            }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      })
    },
    getReport() {
      this.isLoading = true
      this.SET_PROMISE_READY(false)
      axios.get('/api/reports', {
        headers: {'Content-Type': 'application/json'},
      })
          .then(response => {
            let arr = []
            for (let item in response.data) {
              arr.push(response.data[item])
            }
            this.isLoading = false
            this.SET_PROMISE_READY(true)
            this.myChart(response.data.produced, response.data.sold)
          })
          .then(response => {
            return response
          })
          .catch(function (error) {
            console.log(error);
          })
    }
  },
  computed: {
    data() {
      return this.report
    },
    ctx() {
      return document.getElementById("myChart").getContext("2d")
    },

  },
  mounted() {
    this.getReport()
    this.myChart
  }
}
</script>

<style scoped>

</style>
