<template>
  <div class="container">
    <month-selector-component></month-selector-component>
    <!--        <div class="btn-group mr-2" role="group" aria-label="Second group">-->
    <!--            <button type="button" class="btn btn-secondary"-->
    <!--                    @click="decreaseMonth"-->
    <!--            > <-->
    <!--            </button>-->
    <!--            <button type="button" class="btn btn-outline-secondary monthBtn"-->
    <!--                    @click="resetMonth"-->
    <!--            >{{ dateFormated.ofMonth }}-->
    <!--            </button>-->
    <!--            <button type="button" class="btn btn-secondary"-->
    <!--                    @click="increaseMonth"-->
    <!--            > >-->
    <!--            </button>-->
    <!--        </div>-->
    <div class="row justify-content-between">
      <div class="col-md-6">
        <materials-component
            class="mt-4"
            :user="user"
            :dateFormated="dateFormated"
            :date="date"
        ></materials-component>
      </div>
      <div class="col-md-6">
        <production-component
            class="mt-4"
            :user="user"
            :dateFormated="dateFormated"
            :date="date"
            @setDate="setDate"
            @decreaseMonth="decreaseMonth"
        ></production-component>
        <motor-component
            class="mt-4"
            :user="user"
            :dateFormated="dateFormated"
            :date="date"
        ></motor-component>
      </div>
    </div>
  </div>
</template>
<!--.toISOString().slice(0,10)-->
<script>
import {mapActions, mapGetters} from 'vuex'

export default {
  name: "HomeWrapperComponent",
  data: function () {
    return {
      date: new Date().toISOString().slice(0, 10),
    }
  },
  props: {
    user: {
      default: ''
    }

  },
  computed: {
    ...mapGetters([
      `DATE`
    ]),

    dateFormated() {
      const dateSplit = this.DATE.split('-')
      const day = dateSplit[2]
      const mnths = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря']
      const ofMnths = ['январь', 'февраль', 'март', 'апрель', 'май', 'июнь', 'июль', 'август', 'сентябрь', 'октябрь', 'ноябрь', 'декабрь']
      const month = mnths[parseInt(dateSplit[1]) - 1]
      const ofMonth = ofMnths[parseInt(dateSplit[1]) - 1]
      const year = dateSplit[0]
      return {day: day, month: month, ofMonth: ofMonth, year: year}
    }
  },
  methods: {
    ...mapActions([
      `SET_DATE`,
      'SET_FORMATED_DATE'
    ]),
    setDate(date) {
      this.SET_DATE(date)
    },
    decreaseMonth() {
      let currentDate = new Date(Date.parse(this.DATE))
      currentDate.setDate(1);
      currentDate.setMonth(currentDate.getMonth() - 1);
      this.localDate = currentDate.toISOString().slice(0, 10)
      this.setDate(currentDate.toISOString().slice(0, 10))
      // console.log(currentDate.toISOString().slice(0, 10))
    },
    increaseMonth() {
      let currentDate = new Date(Date.parse(this.DATE))
      currentDate.setDate(1);
      currentDate.setMonth(currentDate.getMonth() + 1);
      this.localDate = currentDate.toISOString().slice(0, 10)
      this.setDate(currentDate.toISOString().slice(0, 10))
      // console.log(currentDate.toISOString().slice(0, 10))
    },
    resetMonth() {
      this.localDate = new Date().toISOString().slice(0, 10)
      this.setDate(this.localDate)
    },
  },
  mounted() {
// this.SET_FORMATED_DATE(this.dateFormated)
  }
}
</script>

<style scoped>

</style>
