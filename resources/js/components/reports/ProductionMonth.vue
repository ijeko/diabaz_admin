<template>
  <div>
    <div class="card mt-4">
      <div class="card-header">
        <!--        {{ daysInMonth() }}-->
        Произведено продукции за {{ dateFormated.ofMonth }} {{ dateFormated.year }}
      </div>
      <div class="card-body overflow-auto ">
        <component-loader v-if="isLoading"></component-loader>
        <ul class="list-group list-group-horizontal">
          <li class="list-group-item prod">Продукция</li>
          <li class="list-group-item"
              v-for="days in daysInMonth()"
              :key="days.day"
          >{{ days.dayName }}<br>{{ days.day }}
          </li>
        </ul>
        <ul class="list-group list-group-horizontal"
            v-for="product in reportData"
            :key="product.id"
        >
          <li class="list-group-item prod horizontal-scrollable">{{ product.title }}</li>
          <li class="list-group-item "
              v-for="(days, index) in daysInMonth()"
              :key="index"
          >{{ zeroFills(days.day, product) }}
          </li>
        </ul>
        <!--        <div class="table-responsive text-nowrap">-->
        <!--          <table class="table table-striped">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--              <th class="title">Продукция</th>-->
        <!--              <th class="cells text-dark"-->
        <!--                  v-for="day in daysInMonth()"-->
        <!--                  :key="day"-->
        <!--                  :class="{'bg-warning': isWeekend(day) }">-->
        <!--                {{ day }}-->
        <!--              </th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!--            <tr v-for="(product, index) in reportData"-->
        <!--                :key="index"-->
        <!--            >-->
        <!--              &lt;!&ndash;                            v-if="product.dailyProduction.qty.reduce(function(sum, elem) {&ndash;&gt;-->
        <!--              &lt;!&ndash;                            return sum + elem&ndash;&gt;-->
        <!--              &lt;!&ndash;                            }, 0)>0"&ndash;&gt;-->
        <!--              <td class="title">-->
        <!--                {{ product.title }} ({{ product.unit }})-->
        <!--              </td>-->
        <!--              <td class="cells"-->
        <!--                  v-for="(dayProduced, index) in product.dailyProduction"-->
        <!--                  :key="index"-->
        <!--                  :class="{ 'bg-success produced': dayProduced, 'text-secondary': !dayProduced }"-->
        <!--              >{{ zeroFilledDays(product) }}-->
        <!--              </td>-->
        <!--            </tr>-->
        <!--            </tbody>-->
        <!--          </table>-->
        <!--        </div>-->
      </div>
    </div>
    <div class="card mt-4">
      <div class="card-header">Всего произведено за месяц:</div>
      <div class="card-body">
        <table class="table table-striped col-6">
          <thead>
          <tr>
            <th class="title">Продукция</th>
            <th class="cells">Количество</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(product, index) of reportData"
              :key="index"
              v-if="product.monthlyProduction">
            <td class="title">
              {{ product.title }}
            </td>
            <td>
              {{ product.monthlyProduction }} {{ product.unit }}
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "ProductionMonth",
  data() {
    return {
      date: new Date(),
      reportData: [],
      localDate: this.commonDate,
      isLoading: ''
    }
  },
  props: {
    commonDate: '',
    dateFormated: {}
  },
  methods: {
    ...mapActions([
      'GET_PRODUCTS'
    ]),
    zeroFills(day, product) {
       var result = '1'
      for (var production of product.dailyProduction) {
        product.dailyProduction.splice(day, -1)
        if (day !== new Date(production.date).getDate()) {
             result = 0
        } else return 1
      }
      // return product.dailyProduction

    },
    isWeekend(day) {
      let currentDate = new Date(Date.parse(this.commonDate))
      currentDate.setDate(day);
      let isWeekend = (currentDate.getDay() === 6) || (currentDate.getDay() === 0);    // 6 = Saturday, 0 = Sunday
      return isWeekend
    },
    daysInMonth() {
      // var getDaysArray = function(year, month) {
      const year = new Date(this.DATE).getFullYear()
      const month = new Date(this.DATE).getMonth()
      var names = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
      var date = new Date(year, month - 1, 1);
      var result = [];
      while (date.getMonth() == month - 1) {
        result.push({day: date.getDate(), dayName: names[date.getDay()]});
        date.setDate(date.getDate() + 1);
      }
      return result;
      // }

      // let date = new Date(Date.parse(this.commonDate))
      // return new Date(date.getFullYear(),
      //     date.getMonth() + 1,
      //     0).getDate();
    },
    getReport() {
      this.isLoading = true
      axios.get('/api/reports/monthly', {
        headers: {'Content-Type': 'application/json'},
        // params: data
      })
          .then(response => {
            this.reportData = response.data
            this.isLoading = false
            return response.data
          })
          .catch(function (error) {
            // handle error
            console.log(error);
          })
    }
  },
  computed: {
    ...mapGetters([
      'PRODUCTS',
      'DATE'
    ]),
    zf (day, product) {
      for (var production of product.dailyProduction) {
        if (day === new Date(production.date).getDate()) {
          return  production.date
        } else  return 0
      }
    }
  },
  watch: {
    // эта функция запускается при любом изменении вопроса
    commonDate: function (newLocalDate, oldCLocalDate) {
      this.getReport()
    }
  },
  mounted() {
    this.getReport()
    this.isWeekend()
  }
}
</script>

<style scoped>
.prod {
  width: 250px!important;
}
.horizontal-scrollable {
  overflow-x: auto;
}
table {
  width: 100%;
}

td, th {
  padding: 2px;
  text-align: center;
}

tr {
  border: 1px solid transparent;
}

tr:hover {
  /*border-inline: 1px solid #1f6fb2;*/
  /*background-color: whitesmoke;*/
}

td:hover {
  /*border-inline: 1px solid #1f6fb2;*/
  /*background-color: whitesmoke;*/
}

.cells {
  width: 2.9%;
  /*border-left: 1px solid silver;*/
  /*border-right: 1px solid silver;*/
}

.title {
  width: 150px;
  text-align: left;
}

.monthBtn {
  width: 100px;
}
</style>
